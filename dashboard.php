<?php include('top1.html'); ?>  <!-- This will include the top layout -->
<?php
// Start a session to maintain user state across pages
session_start();

// Security check: if the user is not logged in, redirect to the login page
// This prevents unauthorized access to the dashboard
if (!isset($_SESSION['logged_in'])) {
    header("Location: index.html");
    exit(); // Terminate script execution after redirect
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <!-- Link to external stylesheet for consistent styling -->
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="container">
        <h1>Welcome to the Dashboard</h1>
        <!-- Navigation buttons for main application features -->
        <div class="button-container">
            <a href="fabric_inventory.php"><button>Fabric Inventory</button></a>
            <a href="wage_management.php"><button>Wage Management</button></a>
        </div>
    </div>

    <script src="script.js"></script>
</body>
</html>