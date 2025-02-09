<?php
session_start();
if (!isset($_SESSION['admin_logged_in'])) {
    header('Location: admin_login.php');
    exit;
}
include '../includes/db_connection.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $service_name = $_POST['service_name'];
    $description = $_POST['description'];
    $price = $_POST['price'];

    $query = "INSERT INTO services (service_name, description, price) VALUES (?, ?, ?)";
    $stmt = $conn->prepare($query);
    $stmt->bind_param('ssd', $service_name, $description, $price);

    if ($stmt->execute()) {
        echo "<script>alert('Service added successfully'); window.location.href = 'admin_dashboard.php';</script>";
    } else {
        echo "<script>alert('Failed to add service');</script>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Service</title>
</head>
<body>
    <form method="POST" action="">
        <h2>Add New Service</h2>

        <label for="service_name">Service Name:</label>
        <input type="text" name="service_name" id="service_name" required><br>

        <label for="description">Description:</label>
        <textarea name="description" id="description" required></textarea><br>

        <label for="price">Price:</label>
        <input type="number" name="price" id="price" required><br>

        <button type="submit">Add Service</button>
    </form>
</body>
</html>