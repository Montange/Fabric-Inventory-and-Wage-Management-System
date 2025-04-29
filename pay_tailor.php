<?php
session_start();

if (!isset($_SESSION['logged_in'])) {
    header("Location: index.html");
    exit();
}

include 'db.php';

// Check if 'id' is passed in the URL
if (isset($_GET['id'])) {
    $tailor_id = $_GET['id'];

    // Query to update compensation to 0
    $query = "UPDATE tailors SET current_compensation = 0 WHERE id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $tailor_id); // bind the id as an integer
    $stmt->execute();

    if ($stmt->affected_rows > 0) {
        echo "Compensation reset successfully.";
    } else {
        echo "Failed to reset compensation.";
    }

    // Redirect back to the compensation status page
    header("Location: view_compensation.php");
    exit();
} else {
    echo "No tailor selected.";
}
?>
