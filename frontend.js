// Add to your frontend
async function submitBooking(formData) {
    try {
        const response = await fetch('backend.php', {
            method: 'POST',
            body: formData
        });
        const result = await response.json();
        if(result.success) {
            showSuccessMessage();
        } else {
            showErrorMessage(result.errors);
        }
    } catch(error) {
        console.error('Error:', error);
    }
}