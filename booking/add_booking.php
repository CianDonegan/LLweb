<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Layla Lawlor Beauty - Booking Form</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@400;700&display=swap" rel="stylesheet">
</head>
<body class="bg-pink-50 min-h-screen flex items-center justify-center">
    <form id="booking-form" method="POST" action="process_booking.php" class="bg-white p-8 rounded-lg shadow-md max-w-lg w-full">
        <h2 class="text-2xl font-serif text-pink-600 mb-6 text-center">Layla Lawlor Beauty Booking Form</h2>

        <label for="client-name" class="block text-gray-700 font-medium mb-2">Name:</label>
        <input
            type="text"
            id="client-name"
            name="client-name"
            required
            class="w-full p-3 border border-gray-300 rounded-lg mb-4 focus:ring-2 focus:ring-pink-300 focus:outline-none"
        >

        <label for="email" class="block text-gray-700 font-medium mb-2">Email:</label>
        <input
            type="email"
            id="email"
            name="email"
            required
            class="w-full p-3 border border-gray-300 rounded-lg mb-4 focus:ring-2 focus:ring-pink-300 focus:outline-none"
        >

        <label for="phone" class="block text-gray-700 font-medium mb-2">Phone:</label>
        <input
            type="tel"
            id="phone"
            name="phone"
            required
            class="w-full p-3 border border-gray-300 rounded-lg mb-4 focus:ring-2 focus:ring-pink-300 focus:outline-none"
        >

        <label for="service" class="block text-gray-700 font-medium mb-2">Service:</label>
        <select
            id="service"
            name="service"
            required
            class="w-full p-3 border border-gray-300 rounded-lg mb-4 focus:ring-2 focus:ring-pink-300 focus:outline-none"
        >
        <?php
            $conn = new mysqli('localhost', 'root', '', 'beauty_bookings');

            // Populate Services
            $services = $conn->query("SELECT * FROM services");
            while ($service = $services->fetch_assoc()) {
                echo "<option value='{$service['id']}'>{$service['service_name']} (€{$service['price']})</option>";
            }
        ?>
        </select>

        <label for="addons" class="block text-gray-700 font-medium mb-2">Add-Ons:</label>
        <select
            id="addons"
            name="addons[]"
            multiple
            class="w-full p-3 border border-gray-300 rounded-lg mb-4 focus:ring-2 focus:ring-pink-300 focus:outline-none"
        >
        <?php
            // Populate Add-Ons
            $addons = $conn->query("SELECT * FROM add_ons");
            while ($addon = $addons->fetch_assoc()) {
                echo "<option value='{$addon['id']}'>{$addon['add_on_name']} (€{$addon['price']})</option>";
            }
        ?>
        </select>

        <label for="date" class="block text-gray-700 font-medium mb-2">Date:</label>
        <input
            type="date"
            id="date"
            name="date"
            required
            class="w-full p-3 border border-gray-300 rounded-lg mb-4 focus:ring-2 focus:ring-pink-300 focus:outline-none"
        >

        <label for="time" class="block text-gray-700 font-medium mb-2">Time:</label>
        <input
            type="time"
            id="time"
            name="time"
            required
            class="w-full p-3 border border-gray-300 rounded-lg mb-6 focus:ring-2 focus:ring-pink-300 focus:outline-none"
        >

        <button
            type="submit"
            class="w-full bg-pink-500 text-white py-3 rounded-lg font-medium hover:bg-pink-600 transition duration-300"
        >
            Book Now
        </button>
    </form>
</body>
</html>
