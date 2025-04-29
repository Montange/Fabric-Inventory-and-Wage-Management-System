<?php include('top.html'); ?>  <!-- This will include the top layout -->

<?php
session_start();

if (!isset($_SESSION['logged_in'])) {
    header("Location: index.html");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Fabric Inventory</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="container">
        <h1>Fabric Inventory</h1>
        <div class="button-container">
            <a href="view_fabric.php"><button>View Fabric Inventory</button></a>
            <a href="add_fabric.php"><button>Add New Fabric</button></a>
            <a href="edit_fabric.php?id=1"><button>Edit Fabric Details</button></a>
        </div>
    </div>
    <script src="script.js"></script>
</body>
</html>
