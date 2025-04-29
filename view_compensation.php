<?php include('top.html'); ?>  <!-- This will include the top layout with navigation elements -->

<?php
// Start a session to maintain user state across pages
session_start();

// Security check: if user is not logged in, redirect to login page
// This prevents unauthorized access to compensation data
if (!isset($_SESSION['logged_in'])) {
    header("Location: index.html");
    exit(); // Terminate script execution after redirect
}

// Include database connection file
include 'db.php';

// Query to fetch all tailors and their current compensation information
// Consider adding ORDER BY to sort the results consistently
$query = "SELECT * FROM tailors";
$result = $conn->query($query);

// Consider adding error handling for the database query
// if (!$result) {
//     die("Database query failed: " . $conn->error);
// }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Compensation Status</title>
    <!-- Link to external stylesheet for consistent styling -->
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="container">
        <h1>View Compensation Status</h1>

        <!-- Table to display tailors and their compensation -->
        <table>
            <tr>
                <th>Name</th>
                <th>Current Compensation</th>
                <th>Actions</th>
            </tr>
            <?php while ($row = $result->fetch_assoc()) { ?>
                <tr>
                    <td><?php echo htmlspecialchars($row['name']); ?></td>
                    <td><?php echo htmlspecialchars($row['current_compensation']); ?></td>
                    <td>
                        <!-- Pay button triggers confirmation dialog via JavaScript -->
                        <button onclick="confirmPay(<?php echo (int)$row['id']; ?>)">Pay</button>
                        <!-- Link to view detailed compensation history for this tailor -->
                        <a href="compensation_history.php?tailor_id=<?= htmlspecialchars($row['id']) ?>">
                            <button>Compensation History</button>
                        </a>
                    </td>
                </tr>
            <?php } ?>
            <?php if ($result->num_rows === 0) { ?>
                <tr>
                    <td colspan="3">No tailors found in the database.</td>
                </tr>
            <?php } ?>
        </table>
    </div>

    <!-- Confirmation Dialog - Modal overlay for payment confirmation -->
    <div id="confirmationDialog" class="dialog-overlay">
        <div class="dialog">
            <p>Are you sure you want to pay the tailor?</p>
            <button class="confirm" onclick="payTailor()">Yes</button>
            <button class="cancel" onclick="closeDialog()">No</button>
        </div>
    </div>

    <!-- Link to external JavaScript file for general functionality -->
    <script src="script.js"></script>

    <!-- Inline JavaScript for the confirmation dialog functionality -->
    <script>
        // Variable to store the ID of the tailor selected for payment
        let tailorId = null;

        // Show the confirmation dialog and store the tailor ID
        function confirmPay(id) {
            tailorId = id;
            document.getElementById('confirmationDialog').style.display = 'flex';
        }

        // Hide the confirmation dialog when canceled
        function closeDialog() {
            document.getElementById('confirmationDialog').style.display = 'none';
        }

        // Redirect to the payment processing page with the tailor ID
        function payTailor() {
            if (tailorId !== null) {
                window.location.href = "pay_tailor.php?id=" + tailorId;
            }
            closeDialog(); // Close the dialog after initiating payment
        }
    </script>
</body>
</html>