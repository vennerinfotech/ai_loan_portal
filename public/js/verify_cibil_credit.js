document.addEventListener('DOMContentLoaded', () => {
    console.log('CIBIL/CRIF Credit Report Fetching page loaded.');

    // --- Configuration ---
    const redirectURL = '/cibil_credit_score_report';

    // Time the user waits on the current processing page (simulating data fetching)
    const initialHoldTime = 2000; // 5 seconds

    // Time the success popup is displayed before final redirect
    const popupDisplayTime = 5000; // 5 seconds

    console.log(`Simulating credit report fetching for ${initialHoldTime / 1000} seconds...`);

    // STEP 1: Wait for the initial 5-second simulation time
    setTimeout(() => {

        console.log('Fetching simulation complete. Showing success popup now.');

        // STEP 2: Show the success popup (SweetAlert2 is required in your HTML)
        Swal.fire({
            title: 'Credit Report Successfully Fetched!',
            // Displaying a live countdown in the HTML of the popup
            html: `Report successfully generated. Redirecting automatically in <b>5</b> seconds...`,
            icon: 'success',
            allowOutsideClick: false, // User cannot dismiss the alert by clicking outside
            showConfirmButton: false, // No manual button to click
            timer: popupDisplayTime,
            timerProgressBar: true,

            // Logic to update the countdown text inside the popup
            didOpen: () => {
                const content = Swal.getHtmlContainer();
                const b = content.querySelector('b');
                let timerInterval = setInterval(() => {
                    const remaining = Math.ceil(Swal.getTimerLeft() / 1000);
                    if (b) {
                        b.textContent = remaining;
                    }
                }, 100);

                // Clear the interval when the timer completes
                Swal.getPopup().addEventListener('close', () => {
                    clearInterval(timerInterval);
                });
            },

        // STEP 3: Redirect after the popup timer finishes
        }).then(() => {
            console.log(`Redirecting to credit score report at: ${redirectURL}`);
            window.location.href = redirectURL;
        });

    }, initialHoldTime); // Executes after 5 seconds of initial hold
});
