<?php
include 'db.php';

$tailor_id = $_POST['tailor_id'];
$output_type = $_POST['output_type'];
$quantity = $_POST['quantity'];

// Insert output record
$stmt = $conn->prepare("INSERT INTO outputs (tailor_id, output_type, quantity) VALUES (?, ?, ?)");
$stmt->bind_param("isi", $tailor_id, $output_type, $quantity);
$stmt->execute();

// Get rate
$res = $conn->query("SELECT rate FROM output_rates WHERE output_type='$output_type'");
$rate = $res->fetch_assoc()['rate'];
$added_comp = $quantity * $rate;

// Update current compensation
$conn->query("UPDATE tailors SET current_compensation = current_compensation + $added_comp WHERE id=$tailor_id");

header("Location: wage_management.php");
?>
