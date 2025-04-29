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
    <title>Wage Management</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    
    <div class="container">
        <h1>Wage Management</h1>
        <div class="button-container">
            <a href="search_tailor.php"><button>Search Tailors</button></a>
            <a href="add_compensation.php"><button>Add Compensation</button></a>
            <a href="view_compensation.php"><button>View Compensation</button></a>
            <a href="add_tailor.php"><button>Add Tailor</button></a> 
        </div>
    </div>

    <script src="script.js"></script>
</body>
</html>
