document.addEventListener('DOMContentLoaded', () => {
    const panInput = document.getElementById('pan');
    const panForm = document.getElementById('panForm');

    // PAN uppercase, only A–Z and 0–9, limit 10 characters
    panInput.addEventListener('input', (event) => {
        let value = event.target.value.toUpperCase().replace(/[^A-Z0-9]/g, '');
        event.target.value = value.substring(0, 10);
    });

    panForm.addEventListener('submit', (event) => {
        event.preventDefault();

        const rawPAN = panInput.value.trim();

        // ✅ TEST PAN NUMBER
        const testPAN = "AAAAAAAAAA";

        // SUCCESS CASE
        if (rawPAN === testPAN) {
            Swal.fire({
                icon: 'success',
                title: 'PAN Verified Successfully!',
                text: 'Redirecting to verification page...',
                confirmButtonColor: '#28a745',
                timer: 1500,
                showConfirmButton: false
            }).then(() => {
                window.location.href = '/verify_pan_number';  // Laravel route
            });
        }

        // ERROR CASE
        else {
            const popupHtml = `
                <div class="custom-pan-content">
                    <div class="icon mb-3">
                        <i class="bi bi-exclamation-triangle-fill text-danger fs-2"></i>
                    </div>

                    <h4 class="fw-bold">PAN Verification Failed</h4>

                    <p class="text-muted small mt-2">
                        We could not verify your PAN number. Please upload your PAN card for manual verification.
                    </p>

                    <button id="upload-btn"
                        class="button upload-aadhaar-btn w-100 mb-2 mt-3">
                        Upload PAN
                    </button>

                    <button id="retry-pan-btn" class="button cancel-btn w-100">
                        Retry
                    </button>
                </div>
            `;

            Swal.fire({
                html: popupHtml,
                showConfirmButton: false,
                showCloseButton: true,
                customClass: {
                    popup: 'custom-pan-popup',
                    container: 'custom-pan-position'
                }
            });

            // Handle retry + cancel buttons
            document.addEventListener('click', (e) => {

                if (e.target.id === "retry-pan-btn") {
                    Swal.close();
                    panInput.focus();
                }

                if (e.target.id === "upload-btn") {
                    Swal.close();
                    // 👇 આ એ ફેરફાર છે જે તમને જોઈતો હતો!
                    window.location.href = '/upload_pan_document';
                }
            });
        }
    });
});











