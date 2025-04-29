<?php include('top.html'); ?>  <!-- This will include the top layout -->

<?php
session_start();

if (!isset($_SESSION['logged_in'])) {
    header("Location: index.html");
    exit();
}

include 'db.php';

// Initialize the message variable
$message = '';
$message_type = '';  // 'success' or 'error'

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $tailor_id = $_POST['tailor_id'];
    $output_type = $_POST['output_type'];
    $output_quantity = $_POST['output_quantity'];

    // Fetch current compensation
    $stmt = $conn->prepare("SELECT current_compensation FROM tailors WHERE id = ?");
    $stmt->bind_param("i", $tailor_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $tailor = $result->fetch_assoc();

    if ($tailor) {
        $new_compensation = $tailor['current_compensation'] + ($output_quantity * 10); // Rate = 10

        // Update tailor compensation
        $update_stmt = $conn->prepare("UPDATE tailors SET current_compensation = ? WHERE id = ?");
        $update_stmt->bind_param("di", $new_compensation, $tailor_id);

        // Also insert into outputs table for history
        $insert_output_stmt = $conn->prepare("INSERT INTO outputs (tailor_id, output_type, quantity) VALUES (?, ?, ?)");
        $insert_output_stmt->bind_param("isi", $tailor_id, $output_type, $output_quantity);

        if ($update_stmt->execute() && $insert_output_stmt->execute()) {
            $message = "Compensation added successfully!";
            $message_type = 'success';
        } else {
            $message = "Error: " . $conn->error;
            $message_type = 'error';
        }
        
        $update_stmt->close();
        $insert_output_stmt->close();
    } else {
        $message = "Tailor not found.";
        $message_type = 'error';
    }

    $stmt->close();
    $conn->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Compensation</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
<div class="container">
    <h1>Add Compensation</h1>
    <form method="POST" action="add_compensation.php">
        <label for="tailor_id">Select Tailor:</label>
        <select name="tailor_id" id="tailor_id" required>
            <?php
            include 'db.php';
            $result = $conn->query("SELECT * FROM tailors");
            while ($row = $result->fetch_assoc()) {
                echo "<option value='" . $row['id'] . "'>" . $row['name'] . "</option>";
            }
            $conn->close();
            ?>
        </select>

        <label for="output_type">Output Type:</label>
        <select name="output_type" id="output_type" required>
            <option value="Type1">Type1</option>
            <option value="Type2">Type2</option>
        </select>

        <label for="output_quantity">Quantity:</label>
        <input type="number" name="output_quantity" id="output_quantity" required>

        <button type="submit">Add Compensation</button>
    </form>
</div>

<!-- Success/Error Message Dialog -->
<?php if ($message): ?>
    <div class="dialog-overlay" id="messageDialog" style="display: flex;">
        <div class="dialog <?php echo $message_type; ?>">
            <p><?php echo $message; ?></p>
        </div>
    </div>
<?php endif; ?>

<script>
    // Hide dialog after 3 seconds
    <?php if ($message): ?>
    setTimeout(function () {
        document.getElementById('messageDialog').style.display = 'none';
    }, 3000);
    <?php endif; ?>
</script>
</body>
</html>
