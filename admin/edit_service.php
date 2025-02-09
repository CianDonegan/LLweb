<?php


if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];
    
    // For testing, let's print what we're receiving
    echo "Username: " . $username . "<br>";
    
    $stmt = $conn->prepare("SELECT id, password_hash FROM admin_users WHERE username = ?");
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();
    
    if ($result->num_rows === 1) {
        $user = $result->fetch_assoc();
        if (password_verify($password, $user['password_hash'])) {
            $_SESSION['admin_id'] = $user['id'];
            $_SESSION['admin_username'] = $username;
            
            // Let's print the session data
            echo "Session set: ";
            print_r($_SESSION);
            
            header('Location: admin_dashboard.php');
            exit;
        }
    }
    $error = "Invalid credentials";
}

// Add this at the top to see if session persists
var_dump($_SESSION);

session_start();
require_once '../config.php';

// Check if user is logged in
if (!isset($_SESSION['admin_id'])) {
    header('Location: admin_login.php');
    exit;
}

$service_id = $_GET['id'] ?? 0;
$error = '';
$success = '';

// Fetch service details
if ($service_id) {
    $stmt = $conn->prepare("SELECT * FROM services WHERE id = ?");
    $stmt->bind_param("i", $service_id);
    $stmt->execute();
    $service = $stmt->get_result()->fetch_assoc();
    
    if (!$service) {
        header('Location: admin_dashboard.php');
        exit;
    }
}

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = $_POST['name'] ?? '';
    $price = $_POST['price'] ?? 0;
    $duration = $_POST['duration'] ?? 0;
    $description = $_POST['description'] ?? '';
    
    if (!empty($name)) {
        $stmt = $conn->prepare("UPDATE services SET name = ?, price = ?, duration = ?, description = ? WHERE id = ?");
        $stmt->bind_param("sdisi", $name, $price, $duration, $description, $service_id);
        
        if ($stmt->execute()) {
            $success = "Service updated successfully!";
        } else {
            $error = "Error updating service: " . $conn->error;
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Service - Layla Lawlor Beauty</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@400;700&display=swap" rel="stylesheet">
</head>
<body class="bg-pink-50">
    <nav class="bg-pink-600 text-white shadow-lg">
        <div class="container mx-auto px-6 py-4">
            <div class="flex items-center justify-between">
                <h1 class="text-2xl font-serif">Admin Panel</h1>
                <div class="flex items-center space-x-4">
                    <a href="admin_dashboard.php" class="hover:text-pink-200">Dashboard</a>
                    <a href="admin_logout.php" class="hover:text-pink-200">Logout</a>
                </div>
            </div>
        </div>
    </nav>

    <div class="container mx-auto px-6 py-8">
        <div class="max-w-2xl mx-auto">
            <div class="bg-white rounded-lg shadow-md p-6">
                <h2 class="text-2xl font-serif mb-6">Edit Service</h2>

                <?php if ($error): ?>
                    <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4">
                        <?= htmlspecialchars($error) ?>
                    </div>
                <?php endif; ?>

                <?php if ($success): ?>
                    <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4">
                        <?= htmlspecialchars($success) ?>
                    </div>
                <?php endif; ?>

                <form method="POST" class="space-y-6">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Service Name</label>
                        <input 
                            type="text" 
                            name="name" 
                            value="<?= htmlspecialchars($service['name'] ?? '') ?>"
                            required
                            class="w-full p-2 border border-gray-300 rounded-md focus:ring-pink-500 focus:border-pink-500"
                        >
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Price (€)</label>
                        <input 
                            type="number" 
                            name="price" 
                            value="<?= htmlspecialchars($service['price'] ?? '') ?>"
                            step="0.01"
                            required
                            class="w-full p-2 border border-gray-300 rounded-md focus:ring-pink-500 focus:border-pink-500"
                        >
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Duration (minutes)</label>
                        <input 
                            type="number" 
                            name="duration" 
                            value="<?= htmlspecialchars($service['duration'] ?? '') ?>"
                            required
                            class="w-full p-2 border border-gray-300 rounded-md focus:ring-pink-500 focus:border-pink-500"
                        >
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Description</label>
                        <textarea 
                            name="description" 
                            rows="4"
                            class="w-full p-2 border border-gray-300 rounded-md focus:ring-pink-500 focus:border-pink-500"
                        ><?= htmlspecialchars($service['description'] ?? '') ?></textarea>
                    </div>

                    <div class="flex justify-between">
                        <button 
                            type="submit" 
                            class="bg-pink-600 text-white px-6 py-2 rounded-md hover:bg-pink-700 transition-colors"
                        >
                            Update Service
                        </button>
                        <a 
                            href="admin_dashboard.php" 
                            class="bg-gray-200 text-gray-700 px-6 py-2 rounded-md hover:bg-gray-300 transition-colors"
                        >
                            Cancel
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</body>
</html>