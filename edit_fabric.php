<?php include('top.html'); ?>  <!-- This will include the top layout -->

<?php
session_start();
include 'db.php';

// Fetch all fabric records from the database
$result = $conn->query("SELECT * FROM fabric_inventory");

if ($result->num_rows > 0) {
    // Store fabric records in an array
    $fabrics = $result->fetch_all(MYSQLI_ASSOC);
} else {
    echo "No fabrics found!";
    exit;
}

// Handle form submission to update fabric data
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Loop through each fabric to update its details
    foreach ($_POST['id'] as $index => $fabric_id) {
        $name = $_POST['name'][$index];
        $type = $_POST['type'][$index];
        $quantity = $_POST['quantity'][$index];
        $color = $_POST['color'][$index];

        // Update fabric details in the database
        $stmt = $conn->prepare("UPDATE fabric_inventory SET name=?, type=?, quantity=?, color=? WHERE id=?");
        $stmt->bind_param("ssisi", $name, $type, $quantity, $color, $fabric_id);

        $stmt->execute();
    }

    echo "Fabric details updated successfully!";
    $stmt->close();
    $conn->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Fabric Inventory</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="container">
        <h1>View & Edit Fabric Inventory</h1>

        <!-- Form to update fabric details -->
        <form action="view_fabric.php" method="POST">
            <table>
                <thead>
                    <tr>
                        <th>Fabric Name</th>
                        <th>Fabric Type</th>
                        <th>Quantity</th>
                        <th>Color</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($fabrics as $fabric): ?>
                        <tr>
                            <td><input type="text" name="name[]" value="<?php echo $fabric['name']; ?>" required></td>
                            <td><input type="text" name="type[]" value="<?php echo $fabric['type']; ?>" required></td>
                            <td><input type="number" name="quantity[]" value="<?php echo $fabric['quantity']; ?>" required></td>
                            <td><input type="text" name="color[]" value="<?php echo $fabric['color']; ?>" required></td>
                            <input type="hidden" name="id[]" value="<?php echo $fabric['id']; ?>">
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>

            <button type="submit">Update Fabrics</button>
        </form>

        
    </div>
</body>
</html>
