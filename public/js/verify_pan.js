document.addEventListener('DOMContentLoaded', () => {
    console.log('PAN Verification Processing page loaded.');

    // --- Configuration ---
    const redirectURL = '/pan_data_review';

    // 5000ms = 5 seconds: After waiting this long, the popup will start.
    const initialHoldTime = 1000;

    // 5000ms = 5 seconds: This is how long the popup will be shown.
    const popupDisplayTime = 5000;

    console.log(`Holding on current page for ${initialHoldTime / 1000} seconds before showing success popup...`);

    // --- Step 1: Wait for 5 seconds. ---
    setTimeout(() => {

        // Console log shows that it is now the turn of the popup.
        console.log('Initial delay complete. Showing success popup now.');

        // --- Step 2: Show success popup ---
        // Swal.fire({
        //     title: ' PAN Card Verification Successful!',
        //     html: `Processing complete. Redirecting automatically in <b>5</b> seconds...`,
        //     icon: 'success',
        //     allowOutsideClick: false,
        //     showConfirmButton: false,
        //     // The popup will close after this amount of time.
        //     timer: popupDisplayTime,
        //     timerProgressBar: true,

        //     // Countdown logic
        //     didOpen: () => {
        //         const content = Swal.getHtmlContainer();
        //         const b = content.querySelector('b');
        //         // Update time every 100ms
        //         let timerInterval = setInterval(() => {
        //             const remaining = Math.ceil(Swal.getTimerLeft() / 1000);
        //             if (b) {
        //                 b.textContent = remaining;
        //             }
        //         }, 100);

        //         // When the popup closes, clear the interval.
        //         Swal.getPopup().addEventListener('close', () => {
        //             clearInterval(timerInterval);
        //         });
        //     },

        //     // --- Step 3: Redirect after the popup closes ---
        // }).then(() => {
        //     console.log(`Popup finished. Redirecting to ${redirectURL}`);
        //     window.location.href = redirectURL;
        // });

    }, initialHoldTime); // The first 5 second break ends here.
});
