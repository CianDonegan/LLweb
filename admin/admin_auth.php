<?php
session_start();
require_once 'config.php';

class AdminAuth {
    private $conn;
    
    public function __construct($conn) {
        $this->conn = $conn;
    }
    
    public function register($username, $password, $email) {
        // Check if username or email already exists
        $stmt = $this->conn->prepare("SELECT id FROM admin_users WHERE username = ? OR email = ?");
        $stmt->bind_param("ss", $username, $email);
        $stmt->execute();
        if($stmt->get_result()->num_rows > 0) {
            return ['success' => false, 'message' => 'Username or email already exists'];
        }
        
        // Hash password
        $password_hash = password_hash($password, PASSWORD_BCRYPT);
        
        // Insert new admin
        $stmt = $this->conn->prepare("INSERT INTO admin_users (username, password_hash, email) VALUES (?, ?, ?)");
        $stmt->bind_param("sss", $username, $password_hash, $email);
        
        if($stmt->execute()) {
            return ['success' => true, 'message' => 'Admin registered successfully'];
        }
        return ['success' => false, 'message' => 'Registration failed'];
    }
    
    public function login($username, $password) {
        $stmt = $this->conn->prepare("SELECT id, password_hash FROM admin_users WHERE username = ?");
        $stmt->bind_param("s", $username);
        $stmt->execute();
        $result = $stmt->get_result();
        
        if($result->num_rows === 1) {
            $user = $result->fetch_assoc();
            if(password_verify($password, $user['password_hash'])) {
                // Update last login
                $stmt = $this->conn->prepare("UPDATE admin_users SET last_login = CURRENT_TIMESTAMP WHERE id = ?");
                $stmt->bind_param("i", $user['id']);
                $stmt->execute();
                
                $_SESSION['admin_id'] = $user['id'];
                $_SESSION['admin_username'] = $username;
                return ['success' => true, 'message' => 'Login successful'];
            }
        }
        return ['success' => false, 'message' => 'Invalid credentials'];
    }
    
    public function isLoggedIn() {
        return isset($_SESSION['admin_id']);
    }
    
    public function logout() {
        unset($_SESSION['admin_id']);
        unset($_SESSION['admin_username']);
        session_destroy();
    }
}
?>