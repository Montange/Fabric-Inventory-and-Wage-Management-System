<?php include('top.html'); ?>
<?php
session_start();
if (!isset($_SESSION['logged_in'])) {
    header("Location: index.html");
    exit();
}
include 'db.php';

// Initialize the message variable
$message = '';
$message_type = '';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $tailor_id = $_POST['tailor_id'];
    $output_id = $_POST['output_type'];  // Output type is selected by the user
    $output_quantity = $_POST['output_quantity'];

    // Get rate and type based on output_type (now using output_type instead of output_id)
    $stmt = $conn->prepare("SELECT output_type, rate FROM output_rates WHERE output_type = ?");
    $stmt->bind_param("s", $output_id);  // Bind output_type (assuming it's a string)
    $stmt->execute();
    $rate_result = $stmt->get_result();
    $output_data = $rate_result->fetch_assoc();

    if ($output_data) {
        $output_type = $output_data['output_type'];
        $rate = $output_data['rate'];
        $added_comp = $output_quantity * $rate;

        // Update tailor compensation
        $update_stmt = $conn->prepare("UPDATE tailors SET current_compensation = current_compensation + ? WHERE id = ?");
        $update_stmt->bind_param("di", $added_comp, $tailor_id);

        // Insert into outputs
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
        $message = "Invalid output type.";
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
            <?php
            include 'db.php';
            $types = $conn->query("SELECT * FROM output_rates");
            while ($type = $types->fetch_assoc()) {
                echo "<option value='" . $type['output_type'] . "'>" . $type['output_type'] . " (₱" . $type['rate'] . ")</option>";
            }
            $conn->close();
            ?>
        </select>

        <label for="output_quantity">Quantity:</label>
        <input type="number" name="output_quantity" id="output_quantity" required>

        <button type="submit">Add Compensation</button>
    </form>

    <br>
    
</div>

<!-- Message Overlay -->
<?php if ($message): ?>
    <div class="dialog-overlay" id="messageDialog" style="display: flex;">
        <div class="dialog <?php echo $message_type; ?>">
            <p><?php echo $message; ?></p>
        </div>
    </div>
<?php endif; ?>

<script>
function confirmLogout() {
    if (confirm("Are you sure you want to logout?")) {
        window.location.href = "logout.php";
    }
}
<?php if ($message): ?>
    setTimeout(() => {
        document.getElementById('messageDialog').style.display = 'none';
    }, 3000);
<?php endif; ?>
</script>
</body>
</html>
