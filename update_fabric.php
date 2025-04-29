<?php
include 'db.php';
$stmt = $conn->prepare("UPDATE fabric_inventory SET name=?, type=?, quantity=?, color=? WHERE id=?");
$stmt->bind_param("ssisi", $_POST['name'], $_POST['type'], $_POST['quantity'], $_POST['color'], $_POST['id']);
$stmt->execute();
header("Location: fabric_inventory.php");
?>
