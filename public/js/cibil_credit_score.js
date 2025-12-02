document.addEventListener('DOMContentLoaded', () => {
    document.querySelector('.credit-btn-gradient').addEventListener('click', () => {
        console.log('View Full Report action triggered!');
    });
    document.querySelector('.credit-btn-continue').addEventListener('click', () => {
        console.log('Continue action triggered!');
    });
});


document.addEventListener('DOMContentLoaded', () => {
    const continueButton = document.querySelector('.credit-btn-continue');

    // --- Configuration ---
    // Target URL for the 'cibil_crif' route
    const redirectURL = '/final_confirmation';

    if (continueButton) {
        continueButton.addEventListener('click', function() {
            console.log('User clicked Continue. Initiating final confirmation redirect...');

            // Show a simple success popup before redirecting
            Swal.fire({
                icon: 'success',
                title: 'Proceeding to Confirmation',
                text: 'You will now be redirected to the final confirmation page.',
                showConfirmButton: false,
                timer: 1000, // Short timer for quick transition
                timerProgressBar: true
            }).then(() => {
                // Redirect happens after the timer expires
                window.location.href = redirectURL;
            });
        });
    }
});
