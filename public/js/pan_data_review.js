// /**
//  * Toggles the readonly attribute of a specific form field.
//  * @param {string} fieldId - The ID of the input field to edit.
//  */
// function enableEdit(fieldId) {
//     const field = document.getElementById(fieldId);
//     if (field) {
//         field.removeAttribute('readonly');
//         field.focus();
//     }
// }

// document.addEventListener('DOMContentLoaded', () => {
//     const editDetailsBtn = document.getElementById('editDetailsBtn');
//     const formFields = document.querySelectorAll('.field-input');

//     // Functionality for the main 'Edit Details' button
//     editDetailsBtn.addEventListener('click', () => {
//         formFields.forEach(field => {
//             field.removeAttribute('readonly');
//         });

//         // Simple state change for demonstration
//         editDetailsBtn.textContent = 'Save Changes';
//         editDetailsBtn.classList.remove('custom-btn-light');
//         editDetailsBtn.classList.add('btn-warning');
//     });
// });




/**
 * Toggles the readonly attribute of a specific form field.
 * @param {string} fieldId - The ID of the input field to edit.
 */
function enableEdit(fieldId) {
    const field = document.getElementById(fieldId);
    if (field) {
        field.removeAttribute('readonly');
        field.focus();
    }
}

document.addEventListener('DOMContentLoaded', () => {
    const editDetailsBtn = document.getElementById('editDetailsBtn');
    const formFields = document.querySelectorAll('.field-input');

    const panReviewForm = document.getElementById('panReviewForm');

    editDetailsBtn.addEventListener('click', () => {
        formFields.forEach(field => {
            field.removeAttribute('readonly');
        });

        editDetailsBtn.textContent = 'Save Changes';
        editDetailsBtn.classList.remove('custom-btn-light');
        editDetailsBtn.classList.add('btn-warning');
    });

    if (panReviewForm) {
        panReviewForm.addEventListener('submit', (event) => {
            event.preventDefault();
            window.location.href = '/pan_verification_completed';
        });
    }
});
