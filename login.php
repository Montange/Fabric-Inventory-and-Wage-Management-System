<?php
session_start();
include 'db.php'; // Make sure db.php contains the database connection

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get the username and password from the POST data
    $user = $_POST['username'];
    $pass = $_POST['password'];

    // Use prepared statements to prevent SQL injection
    $stmt = $conn->prepare("SELECT * FROM manager WHERE username = ?");
    $stmt->bind_param("s", $user);
    $stmt->execute();
    $result = $stmt->get_result();

    // Check if the user exists
    if ($result->num_rows == 1) {
        $user_data = $result->fetch_assoc();

        // Compare the entered password with the stored password (plain text comparison)
        if ($pass == $user_data['password']) {
            // Set session variables
            $_SESSION['logged_in'] = true;
            $_SESSION['username'] = $user_data['username'];  // Store the username for future use

            // Redirect to the dashboard page
            header("Location: dashboard.php");
            exit();
        } else {
            // Redirect back to login with error flag
            header("Location: index.html?error=1");
            exit();
        }
    } else {
        // Redirect back to login with error flag
        header("Location: index.html?error=1");
        exit();
    }

    // Close the prepared statement
    $stmt->close();
} else {
    // Redirect to login page if the form wasn't submitted
    header("Location: index.html");
    exit();
}
?>
