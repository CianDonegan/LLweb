<?php
session_start();
if (!isset($_SESSION['admin_logged_in'])) {
    header('Location: admin_login.php');
    exit;
}

include '../includes/db_connection.php';

if (isset($_GET['id'])) {
    $id = $_GET['id'];
    // Fetch service details
    $query = "SELECT * FROM services WHERE id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param('i', $id);
    $stmt->execute();
    $result = $stmt->get_result();
    $service = $result->fetch_assoc();
    
    if (!$service) {
        echo "<script>alert('Service not found.'); window.location.href = 'admin_dashboard.php';</script>";
        exit;
    }
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $service_name = $_POST['service_name'];
    $description = $_POST['description'];
    $price = $_POST['price'];
    $id = $_POST['service_id']; // Add hidden input for service ID

    // Update service details
    $query = "UPDATE services SET service_name = ?, description = ?, price = ? WHERE id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param('ssdi', $service_name, $description, $price, $id);
    
    if ($stmt->execute()) {
        echo "<script>alert('Service updated successfully'); window.location.href = 'admin_dashboard.php';</script>";
    } else {
        echo "<script>alert('Failed to update service');</script>";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Service</title>
</head>
<body>
    <form method="POST" action="">
        <h2>Edit Service</h2>
        <input type="hidden" name="service_id" value="<?php echo $service['id']; ?>">
        <label for="service_name">Service Name:</label>
        <input type="text" name="service_name" id="service_name" value="<?php echo htmlspecialchars($service['service_name']); ?>" required><br>
        
        <label for="description">Description:</label>
        <textarea name="description" id="description" required><?php echo htmlspecialchars($service['description']); ?></textarea><br>
        
        <label for="price">Price:</label>
        <input type="number" name="price" id="price" value="<?php echo htmlspecialchars($service['price']); ?>" required><br>
        
        <button type="submit">Update Service</button>
        <a href="dashboard.php">Cancel</a>
    </form>
</body>
</html>