document.addEventListener('DOMContentLoaded', function () {
    const togglePassword = document.getElementById('togglePassword');
    const password = document.getElementById('password');
    const submitBtn = document.querySelector('button[type="submit"]');
    const loginForm = document.getElementById('loginForm');

    // Toggle password visibility
    if (togglePassword && password) {
        togglePassword.addEventListener('click', function () {
            const type = password.getAttribute('type') === 'password' ? 'text' : 'password';
            password.setAttribute('type', type);
            const icon = this.querySelector('i');
            icon.classList.toggle('fa-eye');
            icon.classList.toggle('fa-eye-slash');
        });
    }

    // Form Validation on submit
    loginForm.addEventListener('submit', function (e) {
        const emailField = document.getElementById('email');
        const passwordField = document.getElementById('password');
        let isValid = true;

        // Clear previous error messages
        const errorMessages = document.querySelectorAll('.error-message');
        errorMessages.forEach(message => message.remove());
        const inputGroups = document.querySelectorAll('.input-group');
        inputGroups.forEach(group => group.classList.remove('is-invalid-group'));  // Remove the error border

        // Validate email
        if (!emailField.value.trim()) {
            isValid = false;
            showError(emailField, 'Email is required');
            addErrorBorder(emailField);  // Add red border to the parent input-group
        }

        // Validate password
        if (!passwordField.value.trim()) {
            isValid = false;
            showError(passwordField, 'Password is required');
            addErrorBorder(passwordField);  // Add red border to the parent input-group
        }

        // If validation fails, prevent form submission
        if (!isValid) {
            e.preventDefault();
        }
    });

    // Function to show error messages below the field
    function showError(field, message) {
        const errorMessage = document.createElement('div');
        errorMessage.classList.add('error-message', 'text-danger');
        errorMessage.textContent = message;

        // Get the parent input-group element
        const inputGroup = field.closest('.input-group');
        if (inputGroup) {
            // Insert the error message after the input-group
            inputGroup.parentElement.insertBefore(errorMessage, inputGroup.nextSibling);
        }
    }

    // Function to add the red border to the parent input-group
    function addErrorBorder(field) {
        const inputGroup = field.closest('.input-group');
        if (inputGroup) {
            inputGroup.classList.add('is-invalid-group');
        }
    }

});
