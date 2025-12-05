document.addEventListener('DOMContentLoaded', () => {
    const uploadFromGalleryBtn = document.getElementById('galleryButton');  // Gallery button by id
    const fileInput = document.getElementById('fileInput');  // Hidden file input
    const uploadArea = document.querySelector('.pan-upload-area');
    const submitButton = document.querySelector('.pan-btn-success'); // Continue button
    const cancelButton = document.querySelector('.pan-btbuttonn-light'); // Cancel button (for navigation)
    const errorMessageDiv = document.createElement('div'); // Error message div

    let previewBox = null; // To keep track of the existing preview box

    // Trigger the file input click when the gallery button is clicked
    uploadFromGalleryBtn.addEventListener('click', (event) => {
        event.preventDefault(); // Prevent any default behavior (form submission or page reload)
        fileInput.click(); // This will open the file dialog
    });

    // Handle file selection after the input dialog is opened
    fileInput.addEventListener('change', handleFileSelect);

    // Function to handle file selection and show preview
    function handleFileSelect(event) {
        const file = event.target.files[0]; // Get the selected file

        // Validate the file type (only image or PDF)
        if (file) {
            const validTypes = ['image/jpeg', 'image/png', 'application/pdf'];
            if (!validTypes.includes(file.type)) {
                alert('Please upload a valid image (JPG, PNG) or PDF file.');
                return;
            }

            // Validate the file size (10 MB max)
            if (file.size > 10 * 1024 * 1024) {
                alert('File size exceeds the maximum limit of 10 MB.');
                return;
            }

            // If an old preview exists, remove it
            if (previewBox) {
                previewBox.remove();
            }

            // Show a new preview of the uploaded file
            showPreview(file);
        }
    }

    function showPreview(file) {
        const reader = new FileReader();

        reader.onload = function (e) {
            // Create the preview box for the new image
            previewBox = document.createElement('div');
            previewBox.classList.add('pan-image-preview-box');
            previewBox.style.position = 'relative'; // Make sure it's positioned for the cancel icon

            // Append the preview box inside the upload area
            uploadArea.appendChild(previewBox);

            const fileType = file.type;

            if (fileType.startsWith('image/')) {
                const imgElement = document.createElement('img');
                imgElement.src = e.target.result;
                imgElement.classList.add('img-fluid');
                previewBox.appendChild(imgElement);
            } else if (fileType === 'application/pdf') {
                const pdfPreview = document.createElement('embed');
                pdfPreview.src = e.target.result;
                pdfPreview.type = 'application/pdf';
                pdfPreview.classList.add('img-fluid');
                previewBox.appendChild(pdfPreview);
            }

            // Add cancel icon (X) inside the preview box
            const cancelIcon = document.createElement('i');
            cancelIcon.classList.add('fa', 'fa-times', 'text-danger', 'cancel-icon');
            cancelIcon.style.position = 'absolute';
            cancelIcon.style.top = '5px';
            cancelIcon.style.right = '5px';
            cancelIcon.style.fontSize = '24px';
            cancelIcon.style.cursor = 'pointer';
            previewBox.appendChild(cancelIcon);

            // Cancel icon functionality to remove the preview
            cancelIcon.addEventListener('click', () => {
                previewBox.remove();
                // Show the upload options again
                uploadArea.querySelector('i').style.display = 'block';
                uploadArea.querySelector('p').style.display = 'block';
            });

            // Hide the upload area options when the image is shown
            uploadArea.querySelector('i').style.display = 'none';
            uploadArea.querySelector('p').style.display = 'none';
        };

        reader.readAsDataURL(file);
    }

    // Check if image is uploaded before submitting the form
    submitButton.addEventListener('click', (event) => {
        // Check if file input is empty (no file selected)
        if (!fileInput.files.length) {
            event.preventDefault(); // Prevent form submission

            // Add error class to the upload area
            uploadArea.classList.add('error');

            // Add error message
            errorMessageDiv.classList.add('error-message');
            errorMessageDiv.innerText = 'Please upload a Pan card image.';

            // Only append the error message once
            if (!document.querySelector('.error-message')) {
                uploadArea.appendChild(errorMessageDiv);
            }

        } else {
            // Remove the error styling and message if the file is selected
            uploadArea.classList.remove('error');
            if (errorMessageDiv) {
                errorMessageDiv.remove();
            }
        }
    });

    // Handle Cancel Button Logic (if you want to clear the preview)
    cancelButton.addEventListener('click', () => {
        if (previewBox) {
            previewBox.remove(); // Remove the preview when canceling
            uploadArea.querySelector('i').style.display = 'block'; // Show the upload options again
            uploadArea.querySelector('p').style.display = 'block';
        }
    });
});
