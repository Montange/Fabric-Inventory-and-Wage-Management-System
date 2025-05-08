<?php
include('top.html');
session_start();
include 'db.php';

if (!isset($_GET['tailor_id'])) {
    echo "Tailor ID is missing.";
    exit();
}

$tailor_id = $_GET['tailor_id'];

// Fetch tailor info
$tailorQuery = $conn->prepare("SELECT name FROM tailors WHERE id = ?");
$tailorQuery->bind_param("i", $tailor_id);
$tailorQuery->execute();
$tailorResult = $tailorQuery->get_result();
$tailor = $tailorResult->fetch_assoc();
$tailor_name = $tailor['name'];

// Fetch output history
$outputsQuery = $conn->prepare("SELECT output_type, quantity FROM outputs WHERE tailor_id = ?");
$outputsQuery->bind_param("i", $tailor_id);
$outputsQuery->execute();
$outputsResult = $outputsQuery->get_result();

// Fetch payment history
$paymentsQuery = $conn->prepare("SELECT amount, date_paid FROM payments WHERE tailor_id = ? ORDER BY date_paid DESC");
$paymentsQuery->bind_param("i", $tailor_id);
$paymentsQuery->execute();
$paymentsResult = $paymentsQuery->get_result();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Compensation History - <?= htmlspecialchars($tailor_name) ?></title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
<div class="container">
    <h1>Compensation History for <?= htmlspecialchars($tailor_name) ?></h1>

    <h2>Output Transactions</h2>
    <table border="1" cellpadding="10">
        <tr>
            <th>Output Type</th>
            <th>Quantity</th>
            
        </tr>
        <?php while ($row = $outputsResult->fetch_assoc()): ?>
            <tr>
                <td><?= htmlspecialchars($row['output_type']) ?></td>
                <td><?= htmlspecialchars($row['quantity']) ?></td>
            </tr>
        <?php endwhile; ?>
    </table>

    
</div>
</body>
</html>
