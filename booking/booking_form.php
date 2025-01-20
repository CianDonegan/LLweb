<!-- booking_form.php -->
<?php
require_once 'timeslots.php';
require_once 'config.php';

// Get services
$stmt = $conn->prepare("SELECT id, name, duration FROM services");
$stmt->execute();
$services = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
?>

<form id="bookingForm" class="max-w-2xl mx-auto p-6 bg-white rounded-lg shadow-md">
    <div class="mb-6">
        <label class="block text-gray-700 mb-2" for="service">Service</label>
        <select id="service" name="service_id" class="w-full p-3 border border-gray-300 rounded-lg" required>
            <option value="">Select a service</option>
            <?php foreach ($services as $service): ?>
                <option value="<?= htmlspecialchars($service['id']) ?>">
                    <?= htmlspecialchars($service['name']) ?>
                </option>
            <?php endforeach; ?>
        </select>
    </div>

    <div class="mb-6">
        <label class="block text-gray-700 mb-2" for="date">Date</label>
        <input type="date" id="date" name="date" 
               min="<?= date('Y-m-d') ?>" 
               class="w-full p-3 border border-gray-300 rounded-lg" 
               required>
    </div>

    <div class="mb-6">
        <label class="block text-gray-700 mb-2" for="time">Time Slot</label>
        <select id="timeSlot" name="time" class="w-full p-3 border border-gray-300 rounded-lg" required>
            <option value="">Select a date first</option>
        </select>
    </div>

    <!-- Add other form fields here -->

    <button type="submit" class="w-full bg-pink-500 text-white py-3 rounded-lg hover:bg-pink-600 transition-colors">
        Book Appointment
    </button>
</form>

<script>
document.getElementById('date').addEventListener('change', async function() {
    const date = this.value;
    const serviceId = document.getElementById('service').value;
    
    if (date && serviceId) {
        try {
            const response = await fetch(`get_timeslots.php?date=${date}&service_id=${serviceId}`);
            const slots = await response.json();
            
            const timeSlotSelect = document.getElementById('timeSlot');
            timeSlotSelect.innerHTML = '<option value="">Select a time</option>';
            
            slots.forEach(slot => {
                const option = document.createElement('option');
                option.value = slot;
                option.textContent = formatTime(slot);
                timeSlotSelect.appendChild(option);
            });
        } catch (error) {
            console.error('Error fetching time slots:', error);
        }
    }
});

function formatTime(timeStr) {
    const [hours, minutes] = timeStr.split(':');
    const date = new Date();
    date.setHours(hours);
    date.setMinutes(minutes);
    return date.toLocaleTimeString('en-US', { 
        hour: 'numeric', 
        minute: '2-digit', 
        hour12: true 
    });
}
</script>