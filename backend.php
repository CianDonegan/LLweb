<?php
include 'config.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $client_name = $_POST['client_name'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];
    $service_id = $_POST['service_id'];
    $date = $_POST['date'];
    $time = $_POST['time'];

    $sql = "INSERT INTO bookings (client_name, email, phone, service_id, date, time)
            VALUES ('$client_name', '$email', '$phone', '$service_id', '$date', '$time')";

    if ($conn->query($sql) === TRUE) {
        echo "Booking added successfully!";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}
    	
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $conn = new mysqli('localhost', 'root', '', 'beauty_bookings');

    $stmt = $conn->prepare("INSERT INTO bookings (client_name, email, phone, service_id, date, time, additional_notes) VALUES (?, ?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("sssssss", $_POST['client-name'], $_POST['email'], $_POST['phone'], $_POST['service'], $_POST['date'], $_POST['time'], $_POST['notes']);
    $stmt->execute();

    // Get the booking ID
    $bookingId = $stmt->insert_id;

    // Insert add-ons
    if (!empty($_POST['addons'])) {
        foreach ($_POST['addons'] as $addOnId) {
            $stmt = $conn->prepare("INSERT INTO booking_add_ons (booking_id, add_on_id) VALUES (?, ?)");
            $stmt->bind_param("ii", $bookingId, $addOnId);
            $stmt->execute();
        }
    }

    echo "Booking confirmed!";
}


?>

