// get_timeslots.php
<?php
header('Content-Type: application/json');
require_once 'timeslots.php';
require_once 'config.php';

$date = $_GET['date'] ?? null;
$service_id = $_GET['service_id'] ?? null;

if (!$date || !$service_id) {
    http_response_code(400);
    echo json_encode(['error' => 'Missing required parameters']);
    exit;
}

$availableSlots = getAvailableTimeSlots($date, $service_id);
echo json_encode($availableSlots);