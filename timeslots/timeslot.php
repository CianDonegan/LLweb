<?php
// timeslots.php

function getAvailableTimeSlots($date, $service_id) {
    global $conn;
    
    // Get service duration
    $stmt = $conn->prepare("SELECT duration FROM services WHERE id = ?");
    $stmt->bind_param("i", $service_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $service = $result->fetch_assoc();
    $duration = $service['duration'];

    // Get day of week (0 = Sunday, 6 = Saturday)
    $dayOfWeek = date('w', strtotime($date));

    // Get business hours for that day
    $stmt = $conn->prepare("
        SELECT start_time, end_time 
        FROM time_slots 
        WHERE day_of_week = ? AND is_available = 1
    ");
    $stmt->bind_param("i", $dayOfWeek);
    $stmt->execute();
    $result = $stmt->get_result();
    $businessHours = $result->fetch_assoc();

    if (!$businessHours) {
        return []; // Closed on this day
    }

    // Get existing bookings for the date
    $stmt = $conn->prepare("
        SELECT time, duration 
        FROM bookings 
        WHERE date = ?
    ");
    $stmt->bind_param("s", $date);
    $stmt->execute();
    $result = $stmt->get_result();
    $existingBookings = $result->fetch_all(MYSQLI_ASSOC);

    // Generate time slots
    $slots = [];
    $startTime = strtotime($businessHours['start_time']);
    $endTime = strtotime($businessHours['end_time']);
    $interval = 30 * 60; // 30-minute intervals

    while ($startTime < $endTime) {
        $slotTime = date('H:i:s', $startTime);
        
        // Check if slot is available
        $isAvailable = true;
        foreach ($existingBookings as $booking) {
            $bookingStart = strtotime($booking['time']);
            $bookingEnd = $bookingStart + ($booking['duration'] * 60);
            $slotEnd = $startTime + $duration * 60;
            
            if (($startTime >= $bookingStart && $startTime < $bookingEnd) ||
                ($slotEnd > $bookingStart && $slotEnd <= $bookingEnd)) {
                $isAvailable = false;
                break;
            }
        }

        if ($isAvailable) {
            $slots[] = $slotTime;
        }

        $startTime += $interval;
    }

    return $slots;
}

// Function to format time for display
function formatTimeSlot($time) {
    return date('g:i A', strtotime($time));
}
?>