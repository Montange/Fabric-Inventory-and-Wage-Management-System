<?php include('top.html'); ?>  <!-- This will include the top layout with navigation elements -->

<?php
// Start a session to maintain user state across pages
session_start();

// Security check: if user is not logged in, redirect to login page
// This prevents unauthorized access to tailor information
if (!isset($_SESSION['logged_in'])) {
    header("Location: index.html");
    exit(); // Terminate script execution after redirect
}

// Include database connection file
include 'db.php';

// Get search term from POST data or set empty if not provided
$search = isset($_POST['search']) ? $_POST['search'] : '';

// Prepare the query using parameterized statement to prevent SQL injection
// Search across multiple columns (name, phone, address) using LIKE for partial matches
$query = "SELECT * FROM tailors WHERE name LIKE ? OR phone LIKE ? OR address LIKE ?";
$stmt = $conn->prepare($query);
$search_term = "%" . $search . "%"; // Add wildcards for partial matching
$stmt->bind_param("sss", $search_term, $search_term, $search_term);
$stmt->execute();
$result = $stmt->get_result();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Search Tailors</title>
    <!-- Link to external stylesheet for consistent styling -->
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="container">
        <h1>Search Tailors</h1>
        
        <!-- Search form that posts back to the same page -->
        <form action="search_tailor.php" method="POST">
            <input type="text" name="search" placeholder="Search by name, phone, or address" 
                   value="<?php echo htmlspecialchars($search); ?>" required>
            <button type="submit">Search</button>
        </form>

        <!-- Table to display search results -->
        <table>
            <tr>
                <th>Name</th>
                <th>Phone</th>
                <th>Address</th>
                <th>Actions</th>
            </tr>
            <?php while ($row = $result->fetch_assoc()) { ?>
                <tr>
                    <td><?php echo htmlspecialchars($row['name']); ?></td>
                    <td><?php echo htmlspecialchars($row['phone']); ?></td>
                    <td><?php echo htmlspecialchars($row['address']); ?></td>
                    <td>
                        <!-- Button linking to compensation form with tailor ID -->
                        <button onclick="window.location.href='add_compensation.php?id=<?php echo htmlspecialchars($row['id']); ?>'">Add Compensation</button>
                    </td>
                </tr>
            <?php } ?>
            <?php if ($result->num_rows === 0 && $search !== '') { ?>
                <tr>
                    <td colspan="4">No tailors found matching your search criteria.</td>
                </tr>
            <?php } ?>
        </table>
        
    </div>

    <!-- Link to external JavaScript file for any interactive functionality -->
    <script src="script.js"></script>
</body>
</html>