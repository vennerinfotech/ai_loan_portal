document.addEventListener('DOMContentLoaded', function () {
    // Get necessary elements by their IDs
    const form = document.getElementById('aadhaarForm');
    const successMessage = document.getElementById('successMessage');
    const formHeader = document.getElementById('formHeader');
    const securityFooter = document.getElementById('securityFooter');
    // Get the first .review-card element (the one containing the form)
    const reviewCard = document.querySelector('.review-card');

    // 1. Handle Form Submission
    if (form) {
        form.addEventListener('submit', function (event) {
            // Prevent page reload
            event.preventDefault();

            // Hide the form-specific elements and show the success message
            formHeader.style.display = 'none';
            securityFooter.style.display = 'none';

            // Hide the main review card container (which holds the form)
            reviewCard.style.display = 'none';

            // Show the success message container
            successMessage.style.display = 'block';
        });
    }
});

// 2. Function for "Back to Edit" button
function handleBack() {
    alert("Redirecting to the previous page where you can edit your details...");
    // window.history.back(); // Use this line for actual navigation
}

// 3. Function to reset/navigate after success
function resetForm() {
    alert("Navigating to Dashboard...");
    // window.location.href = '/dashboard'; // Use this line for actual navigation

    // For demo, reloads the page to show the form again
    window.location.reload();
}
