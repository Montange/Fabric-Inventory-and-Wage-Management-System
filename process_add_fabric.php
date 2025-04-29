<?php
include 'db.php';
$stmt = $conn->prepare("INSERT INTO fabric_inventory (name, type, quantity, color) VALUES (?, ?, ?, ?)");
$stmt->bind_param("ssis", $_POST['name'], $_POST['type'], $_POST['quantity'], $_POST['color']);
$stmt->execute();
header("Location: fabric_inventory.php");
?>
