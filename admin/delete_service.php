
<?php
// Delete Service.php

session_start();
if (!isset($_SESSION['admin_logged_in'])) {
    header('Location: admin_login.php');
    exit;
}
include '../includes/db_connection.php';

if (isset($_GET['id'])) {
    $id = $_GET['id'];

    // Delete service query
    $query = "DELETE FROM services WHERE id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param('i', $id);

    if ($stmt->execute()) {
        echo "<script>alert('Service deleted successfully'); window.location.href = 'admin_dashboard.php';</script>";
    } else {
        echo "<script>alert('Failed to delete service'); window.location.href = 'admin_dashboard.php';</script>";
    }
}
?>
