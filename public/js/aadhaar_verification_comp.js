// Placeholder functions for button actions
// function continueAction() {
//     console.log("Action: Continue");
//     alert("Continuing to the next step...");
// }

// function downloadReceipt() {
//     console.log("Action: Download Verification Receipt");
//     alert("Initiating download...");
// }

// function contactSupport() {
//     console.log("Action: Contact Support");
//     alert("Opening Contact Support page...");
// }


// Placeholder functions for button actions using SweetAlert2
function continueAction() {
    console.log("Action: Continue");

    // Redirect to the '/enter-pan' route after a small delay
    Swal.fire({
        icon: 'success',
        title: 'Continuing...',
        text: 'Proceeding to the PAN-Card Verification.',
        timer: 1500, // Show for 1.5 second
        showConfirmButton: false
    }).then(() => {
        // This is where the redirect happens, similar to the logic you asked for previously
        window.location.href = '/enter-pan';
    });
}

function downloadReceipt() {
    console.log("Action: Download Verification Receipt");

    // Custom Download Confirmation Popup
    Swal.fire({
        icon: 'success',
        title: 'Download Initiated',
        text: 'Your verification receipt download should begin shortly.',
        confirmButtonText: 'OK',
        confirmButtonColor: '#28a745'
    });
}

function contactSupport() {
    console.log("Action: Contact Support");

    // Custom Contact Support Popup
    Swal.fire({
        icon: 'question',
        title: 'Contact Support',
        html: 'We are redirecting you to our support page.<br>Thank you for your patience.',
        confirmButtonText: 'Go to Support',
        confirmButtonColor: '#3085d6'
    }).then((result) => {
        if (result.isConfirmed) {
            console.log("Redirecting to Support page...");
        }
    });
}
