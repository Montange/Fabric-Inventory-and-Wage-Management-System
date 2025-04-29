<?php
session_start();
include 'db.php';

if (!isset($_SESSION['logged_in'])) {
    header("Location: index.html");
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $tailor_id = $_POST['tailor_id'];

    // Validate input
    if (empty($tailor_id)) {
        echo "Tailor ID is required.";
        exit();
    }

    // Query to get compensation based on tailor ID
    $stmt = $conn->prepare("SELECT current_compensation FROM tailors WHERE id = ?");
    $stmt->bind_param("i", $tailor_id);
    $stmt->execute();
    $stmt->store_result();
    $stmt->bind_result($current_compensation);

    if ($stmt->num_rows > 0) {
        $stmt->fetch();
        echo "<h2>Tailor Compensation: $" . $current_compensation . "</h2>";
    } else {
        echo "No tailor found with that ID.";
    }

    $stmt->close();
}

$conn->close();
?>
