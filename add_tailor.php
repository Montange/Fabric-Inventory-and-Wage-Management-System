<?php 
include('top.html');  
session_start();
include 'db.php';

// Initialize the message variable
$message = '';
$message_type = '';  // 'success' or 'error'

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get the values from the form
    $name = $_POST['name'];
    $phone = $_POST['phone'];
    $address = $_POST['address'];
    $current_compensation = $_POST['current_compensation'];

    // Insert the new tailor into the database
    $stmt = $conn->prepare("INSERT INTO tailors (name, phone, address, current_compensation) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("sssd", $name, $phone, $address, $current_compensation);
    
    if ($stmt->execute()) {
        // Set success message
        $message = "Tailor added successfully!";
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
    <title>Add Tailor</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="container">
        <h1>Add New Tailor</h1>
        
        <!-- Form -->
        <form action="add_tailor.php" method="POST">
            <input type="text" name="name" placeholder="Tailor Name" required>
            <input type="number" name="phone" placeholder="Phone Number" required>
            <input type="text" name="address" placeholder="Address" required>
            <input type="number" name="current_compensation" placeholder="Current Compensation" step="0.01" required>
            <button type="submit">Add Tailor</button>
        </form>
      
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
