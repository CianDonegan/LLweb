// admin_timeslots.php
<?php
require_once '../config.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $dayOfWeek = $_POST['day_of_week'];
    $startTime = $_POST['start_time'];
    $endTime = $_POST['end_time'];
    
    $stmt = $conn->prepare("
        INSERT INTO time_slots (day_of_week, start_time, end_time) 
        VALUES (?, ?, ?)
        ON DUPLICATE KEY UPDATE start_time = ?, end_time = ?
    ");
    $stmt->bind_param("issss", $dayOfWeek, $startTime, $endTime, $startTime, $endTime);
    $stmt->execute();
}

// Fetch current business hours
$stmt = $conn->prepare("SELECT * FROM time_slots ORDER BY day_of_week");
$stmt->execute();
$businessHours = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
?>

<!-- Add your admin form HTML here -->
