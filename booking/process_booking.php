<?php
// config.php - Move this to a separate file in production
define('DB_HOST', 'localhost');
define('DB_USER', 'root');
define('DB_PASS', '');
define('DB_NAME', 'beauty_bookings');

class BookingHandler {
    private $conn;
    private $errors = [];
    private $success = false;

    public function __construct() {
        try {
            $this->conn = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
            if ($this->conn->connect_error) {
                throw new Exception("Connection failed: " . $this->conn->connect_error);
            }
        } catch (Exception $e) {
            $this->errors[] = "Database connection error. Please try again later.";
            error_log($e->getMessage());
        }
    }

    private function validateInput($data) {
        if (empty($data['client-name']) || strlen($data['client-name']) > 100) {
            $this->errors[] = "Please enter a valid name (maximum 100 characters)";
        }
        
        if (!filter_var($data['email'], FILTER_VALIDATE_EMAIL)) {
            $this->errors[] = "Please enter a valid email address";
        }
        
        if (!preg_match("/^[0-9]{10}$/", $data['phone'])) {
            $this->errors[] = "Please enter a valid 10-digit phone number";
        }
        
        if (!strtotime($data['date']) || strtotime($data['date']) < strtotime('today')) {
            $this->errors[] = "Please select a valid future date";
        }
        
        if (!preg_match("/^([01]?[0-9]|2[0-3]):[0-5][0-9]$/", $data['time'])) {
            $this->errors[] = "Please select a valid time";
        }
        
        return empty($this->errors);
    }

    public function processBooking($data) {
        if (!$this->validateInput($data)) {
            return false;
        }

        try {
            $this->conn->begin_transaction();

            // Insert main booking
            $stmt = $this->conn->prepare("INSERT INTO bookings (client_name, email, phone, service_id, date, time) VALUES (?, ?, ?, ?, ?, ?)");
            $stmt->bind_param("sssiss", 
                $data['client-name'],
                $data['email'],
                $data['phone'],
                $data['service'],
                $data['date'],
                $data['time']
            );
            
            if (!$stmt->execute()) {
                throw new Exception("Error creating booking: " . $stmt->error);
            }
            
            $bookingId = $stmt->insert_id;

            // Insert add-ons if any
            if (!empty($data['addons'])) {
                $addonStmt = $this->conn->prepare("INSERT INTO booking_add_ons (booking_id, add_on_id) VALUES (?, ?)");
                foreach ($data['addons'] as $addOnId) {
                    $addonStmt->bind_param("ii", $bookingId, $addOnId);
                    if (!$addonStmt->execute()) {
                        throw new Exception("Error adding add-on: " . $addonStmt->error);
                    }
                }
                $addonStmt->close();
            }

            $this->conn->commit();
            $this->success = true;
            return true;

        } catch (Exception $e) {
            $this->conn->rollback();
            $this->errors[] = "Booking failed. Please try again later.";
            error_log($e->getMessage());
            return false;
        }
    }

    public function getErrors() {
        return $this->errors;
    }

    public function isSuccessful() {
        return $this->success;
    }

    public function __destruct() {
        if ($this->conn) {
            $this->conn->close();
        }
    }
}

// Handle the request
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $handler = new BookingHandler();
    $result = $handler->processBooking($_POST);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Booking Status</title>
    <style>
        :root {
            --primary-color: #4a90e2;
            --success-color: #2ecc71;
            --error-color: #e74c3c;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            line-height: 1.6;
            margin: 0;
            padding: 20px;
            background-color: #f5f5f5;
        }

        .message-container {
            max-width: 600px;
            margin: 40px auto;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            background-color: white;
        }

        .success {
            border-left: 4px solid var(--success-color);
        }

        .error {
            border-left: 4px solid var(--error-color);
        }

        .message-title {
            margin: 0 0 15px 0;
            color: #333;
        }

        .success .message-title {
            color: var(--success-color);
        }

        .error .message-title {
            color: var(--error-color);
        }

        .error-list {
            margin: 0;
            padding-left: 20px;
            color: #666;
        }

        .back-link {
            display: inline-block;
            margin-top: 15px;
            color: var(--primary-color);
            text-decoration: none;
        }

        .back-link:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>
    <?php if (isset($handler)): ?>
        <div class="message-container <?php echo $handler->isSuccessful() ? 'success' : 'error'; ?>">
            <?php if ($handler->isSuccessful()): ?>
                <h2 class="message-title">Booking Successful!</h2>
                <p>Thank you for your booking. We'll send a confirmation email shortly with your booking details.</p>
            <?php else: ?>
                <h2 class="message-title">Booking Failed</h2>
                <ul class="error-list">
                    <?php foreach ($handler->getErrors() as $error): ?>
                        <li><?php echo htmlspecialchars($error); ?></li>
                    <?php endforeach; ?>
                </ul>
            <?php endif; ?>
            <a href="javascript:history.back()" class="back-link">← Back to booking form</a>
        </div>
    <?php endif; ?>
</body>
</html>