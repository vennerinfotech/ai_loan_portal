// document.addEventListener('DOMContentLoaded', function () {
//     const agreeButton = document.getElementById('agreeAndContinue');
//     const cancelButton = document.getElementById('cancel');

//     if (agreeButton) {
//         agreeButton.addEventListener('click', function () {
//             console.log('User agreed and continued. Initiating credit report fetch...');
//             alert('Fetching your credit report...');
//         });
//     }

//     if (cancelButton) {
//         cancelButton.addEventListener('click', function (e) {
//             e.preventDefault();
//             console.log('User cancelled the operation.');
//             alert('Operation cancelled.');
//         });
//     }
// });


document.addEventListener('DOMContentLoaded', function () {
    const agreeButton = document.getElementById('agreeAndContinue');
    const cancelButton = document.getElementById('cancel');

    // --- Configuration ---
    // Target URL for the 'cibil_crifr' route
    const agreeRedirectURL = '/verify_cibil_credit_scores';
    // Target URL for the 'pan_verification_comp' route
    const cancelRedirectURL = '/pan_verification_completed';

    if (agreeButton) {
        agreeButton.addEventListener('click', function () {
            console.log('User agreed and continued. Initiating credit report fetch...');

            // Show an info popup and then redirect to the CIBIL/CRIF route
            Swal.fire({
                icon: 'info',
                title: 'Fetching Data',
                text: 'Your credit report is being retrieved. Please wait...',
                showConfirmButton: false,
                timer: 1500, // Popup displays for 1.5 seconds
                timerProgressBar: true
            }).then(() => {
                // Redirect happens after the timer expires
                window.location.href = agreeRedirectURL;
            });
        });
    }

    if (cancelButton) {
        cancelButton.addEventListener('click', function (e) {
            e.preventDefault(); // Prevents default form submission/action
            console.log('User cancelled the operation.');

            // Show a warning popup and then redirect to the completion page
            Swal.fire({
                icon: 'warning',
                title: 'Operation Cancelled',
                text: 'You have cancelled the credit report process. Redirecting to the completion page.',
                confirmButtonText: 'OK',
                confirmButtonColor: '#d33'
            }).then(() => {
                // Redirect happens after the user clicks 'OK'
                window.location.href = cancelRedirectURL;
            });
        });
    }
});
