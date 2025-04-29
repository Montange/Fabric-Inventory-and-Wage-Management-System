<?php include('top.html'); ?>  <!-- This will include the top layout with navigation elements -->

<?php
// Start a session to maintain user state across pages
session_start();

// Security check: if user is not logged in, redirect to login page
// This prevents unauthorized access to inventory data
if (!isset($_SESSION['logged_in'])) {
    header("Location: index.html");
    exit(); // Terminate script execution after redirect
}

// Include database connection file which should contain the connection setup
include 'db.php';

// Query to fetch all records from the fabric_inventory table
// Consider adding error handling for this database query
$result = $conn->query("SELECT * FROM fabric_inventory");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Fabric</title>
    <!-- Link to external stylesheet for consistent styling -->
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="container">
        <h1>View Fabric</h1>
        <!-- Table to display fabric inventory data -->
        <table>
            <tr>
                <th>Name</th>
                <th>Type</th>
                <th>Quantity</th>
                <th>Color</th>
            </tr>
            <?php 
            // Loop through all records and display them in table rows
            while ($row = $result->fetch_assoc()) { 
            ?>
                <tr>
                    <td><?php echo htmlspecialchars($row['name']); ?></td>
                    <td><?php echo htmlspecialchars($row['type']); ?></td>
                    <td><?php echo htmlspecialchars($row['quantity']); ?></td>
                    <td><?php echo htmlspecialchars($row['color']); ?></td>
                </tr>
            <?php } ?>
        </table>
    </div>
    <!-- Link to external JavaScript file for any interactive functionality -->
    <script src="script.js"></script>
</body>
</html>