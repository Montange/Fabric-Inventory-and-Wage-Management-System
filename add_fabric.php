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
    $name = $_POST['name'];
    $type = $_POST['type'];
    $quantity = $_POST['quantity'];
    $color = $_POST['color'];

    $stmt = $conn->prepare("INSERT INTO fabric_inventory (name, type, quantity, color) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("ssis", $name, $type, $quantity, $color);
    if ($stmt->execute()) {
        // Set success message
        $message = "Fabric added successfully!";
        $message_type = 'success';
    } else {
        // Set error message
        $message = "Error: " . $stmt->error;
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
    <title>Add New Fabric</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="container">
        <h1>Add New Fabric</h1>
        <form method="POST" action="add_fabric.php">
            <label for="name">Fabric Name:</label>
            <input type="text" name="name" id="name" required>
            <label for="type">Type:</label>
            <input type="text" name="type" id="type" required>
            <label for="quantity">Quantity:</label>
            <input type="number" name="quantity" id="quantity" required>
            <label for="color">Color:</label>
            <input type="text" name="color" id="color" required>
            <button type="submit">Add Fabric</button>
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
    </div>

    <script>
        // If there is a message, set a timer to hide the dialog after 3 seconds
        <?php if ($message): ?>
            setTimeout(function() {
                document.getElementById('messageDialog').style.display = 'none';
            }, 3000); // 3 seconds
        <?php endif; ?>
    </script>
</body>
</html>
