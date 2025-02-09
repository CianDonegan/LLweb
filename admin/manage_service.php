<?php
require_once 'service_management.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Services - Admin Panel</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>
<body class="bg-gray-50">
    <div class="container mx-auto px-4 py-8">
        <h1 class="text-2xl font-bold mb-6">Manage Services</h1>
        
        <!-- Add Service Form -->
        <div class="bg-white rounded-lg shadow-md p-6 mb-6">
            <h2 class="text-xl font-semibold mb-4">Add New Service</h2>
            <form id="addServiceForm" class="space-y-4">
                <input type="hidden" name="action" value="add">
                <div>
                    <label class="block text-sm font-medium text-gray-700">Name</label>
                    <input type="text" name="name" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700">Price (€)</label>
                    <input type="number" step="0.01" name="price" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700">Duration (minutes)</label>
                    <input type="number" name="duration" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700">Description</label>
                    <textarea name="description" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm"></textarea>
                </div>
                <button type="submit" class="bg-pink-600 text-white px-4 py-2 rounded-md hover:bg-pink-700">Add Service</button>
            </form>
        </div>
        
        <!-- Services List -->
        <div class="bg-white rounded-lg shadow-md p-6">
            <h2 class="text-xl font-semibold mb-4">Current Services</h2>
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead>
                        <tr>
                            <th class="px-6 py-3 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase">Name</th>
                            <th class="px-6 py-3 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase">Price</th>
                            <th class="px-6 py-3 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase">Duration</th>
                            <th class="px-6 py-3 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        <?php foreach ($services as $service): ?>
                        <tr data-id="<?= $service['id'] ?>">
                            <td class="px-6 py-4 whitespace-nowrap"><?= htmlspecialchars($service['name']) ?></td>
                            <td class="px-6 py-4 whitespace-nowrap">€<?= htmlspecialchars($service['price']) ?></td>
                            <td class="px-6 py-4 whitespace-nowrap"><?= htmlspecialchars($service['duration']) ?> mins</td>
                            <td class="px-6 py-4 whitespace-nowrap space-x-2">
                                <button onclick="editService(<?= $service['id'] ?>)" class="text-indigo-600 hover:text-indigo-900">Edit</button>
                                <button onclick="deleteService(<?= $service['id'] ?>)" class="text-red-600 hover:text-red-900">Delete</button>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <script>
    function editService(id) {
        // Fetch service details and show edit form
        $.get('service_management.php?action=get&id=' + id, function(service) {
            // Populate and show edit form
            $('#editServiceForm input[name="id"]').val(service.id);
            $('#editServiceForm input[name="name"]').val(service.name);
            $('#editServiceForm input[name="price"]').val(service.price);
            $('#editServiceForm input[name="duration"]').val(service.duration);
            $('#editServiceForm textarea[name="description"]').val(service.description);
            $('#editServiceModal').removeClass('hidden');
        });
    }

    function deleteService(id) {
        if(confirm('Are you sure you want to delete this service?')) {
            $.post('service_management.php', {
                action: 'delete',
                id: id
            }, function(response) {
                if(response.success) {
                    $(`tr[data-id="${id}"]`).remove();
                    alert(response.message);
                } else {
                    alert(response.message);
                }
            });
        }
    }

    $('#addServiceForm').on('submit', function(e) {
        e.preventDefault();
        $.post('service_management.php', $(this).serialize(), function(response) {
            if(response.success) {
                location.reload();
            } else {
                alert(response.message);
            }
        });
    });
    </script>
</body>
</html>