<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Business Proof Selection - All Uploads</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">

    <style>
        /* --- General Styling (Unchanged) --- */
        :root {
            --color-dark-blue: #0A2540;
            --color-primary-blue: #2A66FF;
            --color-light-gray: #F7F8FA;
            --color-white: #FFFFFF;
            --shadow-soft: 0px 4px 12px rgba(0, 0, 0, 0.1);
            --border-radius-card: 16px;
            --border-radius-cta: 16px;
            --spacing-default: 24px;
        }

        * { box-sizing: border-box; margin: 0; padding: 0; }
        body { font-family: 'Inter', sans-serif; background-color: var(--color-white); line-height: 1.6; color: var(--color-dark-blue); }
        .screen-container { padding: var(--spacing-default); padding-bottom: 100px; max-width: 420px; margin: 0 auto; }
        .title-section { text-align: center; margin-bottom: 32px; }
        .title-section h1 { font-size: 28px; font-weight: 700; color: var(--color-dark-blue); }
        .section-title { font-size: 18px; font-weight: 600; margin-bottom: 16px; color: var(--color-dark-blue); }

        /* Business Cards Grid (Unchanged) */
        .business-type-selection { margin-bottom: 32px; }
        .card-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 16px; }
        .business-card { background-color: var(--color-white); border-radius: var(--border-radius-card); padding: 20px 16px; display: flex; flex-direction: column; align-items: center; text-align: center; cursor: pointer; border: 2px solid transparent; transition: all 0.2s ease-in-out; box-shadow: var(--shadow-soft); }
        .business-card.selected { border-color: var(--color-primary-blue); box-shadow: 0px 6px 16px rgba(42, 102, 255, 0.2); }
        .business-card i { font-size: 32px; color: var(--color-primary-blue); margin-bottom: 8px; }
        .business-card span { font-size: 14px; font-weight: 600; color: var(--color-dark-blue); }

        /* Document Options Section */
        .document-options-section { margin-bottom: 32px; opacity: 1; max-height: 800px; overflow: hidden; transition: opacity 0.3s ease-in-out, max-height 0.5s ease-in-out; }
        .document-options-section.hidden { opacity: 0; max-height: 0; margin-bottom: 0; }
        .document-list { display: flex; flex-direction: column; gap: 8px; }

        /* --- STYLING FOR CUSTOM UPLOAD ITEMS --- */
        .document-item {
            display: flex;
            align-items: flex-start;
            padding: 12px 16px;
            background-color: var(--color-light-gray);
            border-radius: 12px;
            cursor: default; /* Keep default cursor on the whole item */
            position: relative;
            box-shadow: 0px 2px 4px rgba(0, 0, 0, 0.05);
        }

        /* Checkbox and Checkmark Styles */
        .document-item input[type="checkbox"] { position: absolute; opacity: 0; height: 0; width: 0; }
        .document-item .checkmark { height: 20px; width: 20px; background-color: var(--color-white); border: 2px solid #ccc; border-radius: 4px; margin-right: 12px; flex-shrink: 0; position: relative; cursor: pointer; }
        .document-item input:checked ~ .checkmark { background-color: var(--color-primary-blue); border-color: var(--color-primary-blue); }
        .document-item input:checked ~ .checkmark:after { content: ""; position: absolute; display: block; left: 6px; top: 2px; width: 5px; height: 10px; border: solid white; border-width: 0 3px 3px 0; transform: rotate(45deg); }

        /* Custom Upload Button Styling */
        .upload-content {
            display: flex;
            flex-direction: column;
            flex-grow: 1;
        }

        .upload-content > span {
            font-weight: 600;
            margin-bottom: 8px;
        }

        .upload-trigger {
            background-color: var(--color-white);
            border: 1px solid #D0D0D0;
            border-radius: 8px;
            padding: 10px 12px;
            font-size: 14px;
            font-weight: 600;
            color: var(--color-dark-blue);
            cursor: pointer; /* Pointer only on the button */
            text-align: left;
            display: flex;
            align-items: center;
            justify-content: space-between;
            transition: all 0.2s ease-in-out;
            width: 100%;
        }

        .upload-trigger i {
            font-size: 16px;
            color: var(--color-primary-blue);
            margin-right: 8px;
        }

        .upload-trigger:hover {
            border-color: var(--color-primary-blue);
        }

        .file-name-display {
            flex-grow: 1;
            color: #555;
            overflow: hidden;
            white-space: nowrap;
            text-overflow: ellipsis;
        }

        /* Additional Documents Section (Unchanged) */
        .additional-documents-section { margin-bottom: 32px; }
        .additional-card-scroll { display: flex; gap: 12px; overflow-x: scroll; padding-bottom: 10px; -webkit-overflow-scrolling: touch; }
        .additional-doc-card { flex-shrink: 0; background-color: var(--color-white); border: 1px solid #E0E0E0; border-radius: 12px; padding: 12px 20px; font-size: 14px; font-weight: 500; color: var(--color-dark-blue); box-shadow: var(--shadow-soft); }

        /* CTA Button (Unchanged) */
        .cta-section { position: fixed; bottom: 0; left: 0; right: 0; background-color: var(--color-white); padding: 16px var(--spacing-default); box-shadow: 0px -4px 12px rgba(0, 0, 0, 0.05); z-index: 10; max-width: 420px; margin: 0 auto; }
        .primary-cta { width: 100%; padding: 16px; border: none; border-radius: var(--border-radius-cta); background-color: var(--color-primary-blue); color: var(--color-white); font-size: 16px; font-weight: 700; cursor: pointer; transition: background-color 0.2s ease-in-out; }
        .primary-cta:disabled { background-color: #B3C0D0; cursor: not-allowed; }
    </style>
</head>
<body>
    <div class="screen-container">
        <header class="title-section">
            <h1>Select Your Business Proof</h1>
        </header>

        <section class="business-type-selection">
            <div class="card-grid">
                <div class="business-card" data-type="Salaried"><i class="fas fa-briefcase"></i><span>Salaried</span></div>
                <div class="business-card" data-type="Self-Employed"><i class="fas fa-store-alt"></i><span>Self-Employed</span></div>
                <div class="business-card" data-type="Freelancer"><i class="fas fa-laptop-code"></i><span>Freelancer</span></div>
                <div class="business-card" data-type="Pensioner"><i class="fas fa-file-invoice"></i><span>Pensioner</span></div>
            </div>
        </section>

        <section id="documentOptions" class="document-options-section hidden">
            <h2 class="section-title">Required Documents</h2>
            <div class="document-list">

                <label class="document-item">
                    <input type="checkbox" name="doc" value="Form 16" id="doc_form_16">
                    <span class="checkmark"></span>
                    <div class="upload-content">
                        <span>Form 16</span>
                        <input type="file" id="file_form_16" data-target="doc_form_16" style="display: none;" accept=".pdf,.png,.jpg">
                        <button type="button" class="upload-trigger" data-file-target="file_form_16">
                            <i class="fas fa-file-upload"></i> <span class="file-name-display">Choose File</span>
                        </button>
                    </div>
                </label>

                <label class="document-item">
                    <input type="checkbox" name="doc" value="Salary Slip / Certificate" id="doc_salary_slip">
                    <span class="checkmark"></span>
                    <div class="upload-content">
                        <span>Salary Slip / Certificate</span>
                        <input type="file" id="file_salary_slip" data-target="doc_salary_slip" style="display: none;" accept=".pdf,.png,.jpg">
                        <button type="button" class="upload-trigger" data-file-target="file_salary_slip">
                            <i class="fas fa-file-upload"></i> <span class="file-name-display">Choose File</span>
                        </button>
                    </div>
                </label>

                <label class="document-item">
                    <input type="checkbox" name="doc" value="GST Certificate" id="doc_gst_cert">
                    <span class="checkmark"></span>
                    <div class="upload-content">
                        <span>GST Certificate</span>
                        <input type="file" id="file_gst_cert" data-target="doc_gst_cert" style="display: none;" accept=".pdf,.png,.jpg">
                        <button type="button" class="upload-trigger" data-file-target="file_gst_cert">
                            <i class="fas fa-file-upload"></i> <span class="file-name-display">Choose File</span>
                        </button>
                    </div>
                </label>

                <label class="document-item">
                    <input type="checkbox" name="doc" value="Udyam Registration" id="doc_udyam_reg">
                    <span class="checkmark"></span>
                    <div class="upload-content">
                        <span>Udyam Registration</span>
                        <input type="file" id="file_udyam_reg" data-target="doc_udyam_reg" style="display: none;" accept=".pdf,.png,.jpg">
                        <button type="button" class="upload-trigger" data-file-target="file_udyam_reg">
                            <i class="fas fa-file-upload"></i> <span class="file-name-display">Choose File</span>
                        </button>
                    </div>
                </label>

                <label class="document-item">
                    <input type="checkbox" name="doc" value="MCA: Pvt / LLP" id="doc_mca">
                    <span class="checkmark"></span>
                    <div class="upload-content">
                        <span>MCA: Pvt / LLP</span>
                        <input type="file" id="file_mca" data-target="doc_mca" style="display: none;" accept=".pdf,.png,.jpg">
                        <button type="button" class="upload-trigger" data-file-target="file_mca">
                            <i class="fas fa-file-upload"></i> <span class="file-name-display">Choose File</span>
                        </button>
                    </div>
                </label>

                <label class="document-item">
                    <input type="checkbox" name="doc" value="Others" id="doc_others">
                    <span class="checkmark"></span>
                    <div class="upload-content">
                        <span>Others (Specify)</span>
                        <input type="file" id="file_others" data-target="doc_others" style="display: none;" accept="*/*">
                        <button type="button" class="upload-trigger" data-file-target="file_others">
                            <i class="fas fa-file-upload"></i> <span class="file-name-display">Choose File</span>
                        </button>
                    </div>
                </label>

            </div>
        </section>

        <section class="additional-documents-section">
            <h2 class="section-title">Additional Documents (Optional)</h2>
            <div class="additional-card-scroll">
                <div class="additional-doc-card">ISO + RC</div>
                <div class="additional-doc-card">Shop Act License</div>
                <div class="additional-doc-card">Import Export Code</div>
                <div class="additional-doc-card">PF Registration</div>
            </div>
        </section>

        <div class="spacer"></div>
    </div>

    <footer class="cta-section">
        <button id="ctaButton" class="primary-cta" disabled>
            Upload Documents & Continue
        </button>
    </footer>

    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const businessCards = document.querySelectorAll('.business-card');
            const documentOptions = document.getElementById('documentOptions');
            const ctaButton = document.getElementById('ctaButton');
            const documentCheckboxes = document.querySelectorAll('.document-list input[type="checkbox"]');
            const uploadTriggers = document.querySelectorAll('.upload-trigger');

            // Helper function to update CTA button state
            const updateCtaState = () => {
                const isBusinessTypeSelected = document.querySelector('.business-card.selected') !== null;
                // Check if at least one document checkbox is checked
                const isDocumentSelected = Array.from(documentCheckboxes).some(checkbox => checkbox.checked);

                ctaButton.disabled = !(isBusinessTypeSelected && isDocumentSelected);
            };

            // 1. Business Card Selection Logic
            businessCards.forEach(card => {
                card.addEventListener('click', () => {
                    businessCards.forEach(c => c.classList.remove('selected'));
                    card.classList.add('selected');
                    documentOptions.classList.remove('hidden');
                    updateCtaState();
                });
            });

            // 2. Custom Upload Logic (Connects button, hidden input, and checkbox)
            uploadTriggers.forEach(button => {
                const fileInputId = button.dataset.fileTarget;
                const fileInput = document.getElementById(fileInputId);
                const fileNameDisplay = button.querySelector('.file-name-display');
                const checkboxId = fileInput.dataset.target;
                const checkbox = document.getElementById(checkboxId);

                // A. Link the styled button to the hidden input
                button.addEventListener('click', () => {
                    fileInput.click();
                });

                // B. Handle file selection
                fileInput.addEventListener('change', () => {
                    if (fileInput.files.length > 0) {
                        fileNameDisplay.textContent = fileInput.files[0].name;
                        // File સિલેક્ટ થતાં Checkbox ઓટોમેટિકલી ચેક કરો
                        checkbox.checked = true;
                    } else {
                        // જો યુઝર કેન્સલ કરે, તો રીસેટ કરો
                        fileNameDisplay.textContent = 'Choose File';
                        checkbox.checked = false;
                    }
                    updateCtaState();
                });

                // C. Handle manual checkbox unchecking (resets file field)
                checkbox.addEventListener('change', () => {
                    if (!checkbox.checked) {
                        fileInput.value = ''; // Clear the file input value
                        fileNameDisplay.textContent = 'Choose File';
                    }
                    updateCtaState();
                });
            });


            // 3. Primary CTA Click/Submission Logic
            ctaButton.addEventListener('click', () => {
                if (!ctaButton.disabled) {
                    const selectedType = document.querySelector('.business-card.selected')?.dataset.type || 'N/A';
                    const uploadedDocs = Array.from(documentCheckboxes)
                        .filter(checkbox => checkbox.checked)
                        .map(checkbox => checkbox.value)
                        .join(', ');

                    alert(
                        `✅ Documents Uploaded & Filed Successfully!\n\n` +
                        `Business Type: ${selectedType}\n` +
                        `Documents Submitted: ${uploadedDocs || 'None'}\n\n` +
                        `Proceeding to the next step...`
                    );
                }
            });

            // Initial state check
            updateCtaState();
        });
    </script>
</body>
</html>
