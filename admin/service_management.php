<?php
session_start();
require_once 'config.php';
require_once 'admin_auth.php';

$auth = new AdminAuth($conn);

// Check if user is logged in
if(!$auth->isLoggedIn()) {
    header('Location: admin_login.php');
    exit;
}

class ServiceManager {
    private $conn;
    
    public function __construct($conn) {
        $this->conn = $conn;
    }
    
    public function addService($name, $price, $duration, $description) {
        $stmt = $this->conn->prepare("INSERT INTO services (name, price, duration, description) VALUES (?, ?, ?, ?)");
        $stmt->bind_param("sdis", $name, $price, $duration, $description);
        
        if($stmt->execute()) {
            return ['success' => true, 'message' => 'Service added successfully'];
        }
        return ['success' => false, 'message' => 'Failed to add service'];
    }
    
    public function updateService($id, $name, $price, $duration, $description) {
        $stmt = $this->conn->prepare("UPDATE services SET name = ?, price = ?, duration = ?, description = ? WHERE id = ?");
        $stmt->bind_param("sdisi", $name, $price, $duration, $description, $id);
        
        if($stmt->execute()) {
            return ['success' => true, 'message' => 'Service updated successfully'];
        }
        return ['success' => false, 'message' => 'Failed to update service'];
    }
    
    public function deleteService($id) {
        // First check if service is used in any bookings
        $stmt = $this->conn->prepare("SELECT COUNT(*) FROM bookings WHERE service_id = ?");
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $result = $stmt->get_result();
        $count = $result->fetch_row()[0];
        
        if($count > 0) {
            return ['success' => false, 'message' => 'Cannot delete service: It has existing bookings'];
        }
        
        $stmt = $this->conn->prepare("DELETE FROM services WHERE id = ?");
        $stmt->bind_param("i", $id);
        
        if($stmt->execute()) {
            return ['success' => true, 'message' => 'Service deleted successfully'];
        }
        return ['success' => false, 'message' => 'Failed to delete service'];
    }
    
    public function getService($id) {
        $stmt = $this->conn->prepare("SELECT * FROM services WHERE id = ?");
        $stmt->bind_param("i", $id);
        $stmt->execute();
        return $stmt->get_result()->fetch_assoc();
    }
    
    public function getAllServices() {
        return $this->conn->query("SELECT * FROM services ORDER BY name")->fetch_all(MYSQLI_ASSOC);
    }
}

$serviceManager = new ServiceManager($conn);

// Handle form submissions
if($_SERVER['REQUEST_METHOD'] === 'POST') {
    $action = $_POST['action'] ?? '';
    $result = ['success' => false, 'message' => 'Invalid action'];
    
    switch($action) {
        case 'add':
            $result = $serviceManager->addService(
                $_POST['name'],
                $_POST['price'],
                $_POST['duration'],
                $_POST['description']
            );
            break;
            
        case 'update':
            $result = $serviceManager->updateService(
                $_POST['id'],
                $_POST['name'],
                $_POST['price'],
                $_POST['duration'],
                $_POST['description']
            );
            break;
            
        case 'delete':
            $result = $serviceManager->deleteService($_POST['id']);
            break;
    }
    
    // Return JSON response for AJAX requests
    if(!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest') {
        header('Content-Type: application/json');
        echo json_encode($result);
        exit;
    }
}

// Get all services for display
$services = $serviceManager->getAllServices();
?>