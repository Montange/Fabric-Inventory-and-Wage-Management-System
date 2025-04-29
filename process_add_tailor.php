<?php
include 'db.php';

$name = $_POST['name'];
$current_compensation = $_POST['current_compensation'];

// Insert the new tailor into the database
$stmt = $conn->prepare("INSERT INTO tailors (name, current_compensation) VALUES (?, ?)");
$stmt->bind_param("sd", $name, $current_compensation); // 's' for string, 'd' for decimal
$stmt->execute();

header("Location: wage_management.php"); // Redirect to the wage management page
?>
