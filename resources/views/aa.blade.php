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

        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }

        body {
            font-family: 'Inter', sans-serif;
            background-color: var(--color-white);
            line-height: 1.6;
            color: var(--color-dark-blue);
        }

        .screen-container {
            padding: var(--spacing-default);
            padding-bottom: 100px;
            max-width: 420px;
            margin: 0 auto;
        }

        .title-section {
            text-align: center;
            margin-bottom: 32px;
        }

        .title-section h1 {
            font-size: 28px;
            font-weight: 700;
            color: var(--color-dark-blue);
        }

        .section-title {
            font-size: 18px;
            font-weight: 600;
            margin-bottom: 16px;
            color: var(--color-dark-blue);
        }

        /* Business Cards Grid (Unchanged) */
        .business-type-selection {
            margin-bottom: 32px;
        }

        .card-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 16px;
        }

        .business-card {
            background-color: var(--color-white);
            border-radius: var(--border-radius-card);
            padding: 20px 16px;
            display: flex;
            flex-direction: column;
            align-items: center;
            text-align: center;
            cursor: pointer;
            border: 2px solid transparent;
            transition: all 0.2s ease-in-out;
            box-shadow: var(--shadow-soft);
        }

        .business-card.selected {
            border-color: var(--color-primary-blue);
            box-shadow: 0px 6px 16px rgba(42, 102, 255, 0.2);
        }

        .business-card i {
            font-size: 32px;
            color: var(--color-primary-blue);
            margin-bottom: 8px;
        }

        .business-card span {
            font-size: 14px;
            font-weight: 600;
            color: var(--color-dark-blue);
        }

        /* Document Options Section */
        .document-options-section {
            margin-bottom: 32px;
            opacity: 1;
            max-height: 800px;
            overflow: hidden;
            transition: opacity 0.3s ease-in-out, max-height 0.5s ease-in-out;
        }

        .document-options-section.hidden {
            opacity: 0;
            max-height: 0;
            margin-bottom: 0;
        }

        .document-list {
            display: flex;
            flex-direction: column;
            gap: 8px;
        }

        /* --- STYLING FOR CUSTOM UPLOAD ITEMS --- */
        .document-item {
            display: flex;
            align-items: flex-start;
            padding: 12px 16px;
            background-color: var(--color-light-gray);
            border-radius: 12px;
            cursor: default;
            /* Keep default cursor on the whole item */
            position: relative;
            box-shadow: 0px 2px 4px rgba(0, 0, 0, 0.05);
        }

        /* Checkbox and Checkmark Styles */
        .document-item input[type="checkbox"] {
            position: absolute;
            opacity: 0;
            height: 0;
            width: 0;
        }

        .document-item .checkmark {
            height: 20px;
            width: 20px;
            background-color: var(--color-white);
            border: 2px solid #ccc;
            border-radius: 4px;
            margin-right: 12px;
            flex-shrink: 0;
            position: relative;
            cursor: pointer;
        }

        .document-item input:checked~.checkmark {
            background-color: var(--color-primary-blue);
            border-color: var(--color-primary-blue);
        }

        .document-item input:checked~.checkmark:after {
            content: "";
            position: absolute;
            display: block;
            left: 6px;
            top: 2px;
            width: 5px;
            height: 10px;
            border: solid white;
            border-width: 0 3px 3px 0;
            transform: rotate(45deg);
        }

        /* Custom Upload Button Styling */
        .upload-content {
            display: flex;
            flex-direction: column;
            flex-grow: 1;
        }

        .upload-content>span {
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
            cursor: pointer;
            /* Pointer only on the button */
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
        .additional-documents-section {
            margin-bottom: 32px;
        }

        .additional-card-scroll {
            display: flex;
            gap: 12px;
            overflow-x: scroll;
            padding-bottom: 10px;
            -webkit-overflow-scrolling: touch;
        }

        .additional-doc-card {
            flex-shrink: 0;
            background-color: var(--color-white);
            border: 1px solid #E0E0E0;
            border-radius: 12px;
            padding: 12px 20px;
            font-size: 14px;
            font-weight: 500;
            color: var(--color-dark-blue);
            box-shadow: var(--shadow-soft);
        }

        /* CTA Button (Unchanged) */
        .cta-section {
            position: fixed;
            bottom: 0;
            left: 0;
            right: 0;
            background-color: var(--color-white);
            padding: 16px var(--spacing-default);
            box-shadow: 0px -4px 12px rgba(0, 0, 0, 0.05);
            z-index: 10;
            max-width: 420px;
            margin: 0 auto;
        }

        .primary-cta {
            width: 100%;
            padding: 16px;
            border: none;
            border-radius: var(--border-radius-cta);
            background-color: var(--color-primary-blue);
            color: var(--color-white);
            font-size: 16px;
            font-weight: 700;
            cursor: pointer;
            transition: background-color 0.2s ease-in-out;
        }

        .primary-cta:disabled {
            background-color: #B3C0D0;
            cursor: not-allowed;
        }
    </style>
</head>

<body>
    <div class="screen-container">
        <header class="title-section">
            <h1>Select Your Business Proof</h1>
        </header>

        <section class="business-type-selection">
            <div class="card-grid">
                <div class="business-card" data-type="Salaried"><i class="fas fa-briefcase"></i><span>Salaried</span>
                </div>
                <div class="business-card" data-type="Self-Employed"><i
                        class="fas fa-store-alt"></i><span>Self-Employed</span></div>
                <div class="business-card" data-type="Freelancer"><i
                        class="fas fa-laptop-code"></i><span>Freelancer</span></div>
                <div class="business-card" data-type="Pensioner"><i
                        class="fas fa-file-invoice"></i><span>Pensioner</span></div>
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
                        <input type="file" id="file_form_16" data-target="doc_form_16" style="display: none;"
                            accept=".pdf,.png,.jpg">
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
                        <input type="file" id="file_salary_slip" data-target="doc_salary_slip" style="display: none;"
                            accept=".pdf,.png,.jpg">
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
                        <input type="file" id="file_gst_cert" data-target="doc_gst_cert" style="display: none;"
                            accept=".pdf,.png,.jpg">
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
                        <input type="file" id="file_udyam_reg" data-target="doc_udyam_reg" style="display: none;"
                            accept=".pdf,.png,.jpg">
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
                        <input type="file" id="file_mca" data-target="doc_mca" style="display: none;"
                            accept=".pdf,.png,.jpg">
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
                        <input type="file" id="file_others" data-target="doc_others" style="display: none;"
                            accept="*/*">
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
                    const selectedType = document.querySelector('.business-card.selected')?.dataset.type ||
                        'N/A';
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



{{-- <!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Aadhaar Verification Receipt</title>
    <style>
        /* IMPORT GOOGLE FONTS FOR HINDI & ENGLISH */
        @import url('https://fonts.googleapis.com/css2?family=Noto+Sans+Devanagari:wght@400;700&family=Roboto:wght@400;500;700&display=swap');

        /* PAGE SETUP FOR A4 PDF */
        @page {
            size: A4;
            margin: 0;
        }

        body {
            font-family: 'Roboto', 'Noto Sans Devanagari', sans-serif;
            margin: 0;
            padding: 0;
            background-color: #fff;
            color: #222;
            -webkit-print-color-adjust: exact;
        }

        .container {
            width: 210mm;
            min-height: 297mm;
            padding: 15mm;
            margin: 0 auto;
            position: relative;
            box-sizing: border-box;
            background-image: radial-gradient(circle at center, rgba(0, 0, 0, 0.02) 0%, rgba(255, 255, 255, 1) 70%);
        }

        /* HEADER SECTION */
        .header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            border-bottom: 3px solid #db8e31;
            /* Saffron Line */
            padding-bottom: 15px;
            margin-bottom: 20px;
        }

        .header-center {
            text-align: center;
            flex-grow: 1;
        }

        .header-center h1 {
            font-size: 16pt;
            font-weight: 700;
            margin: 0;
            text-transform: uppercase;
            line-height: 1.2;
        }

        .header-center h2 {
            font-size: 11pt;
            font-weight: 500;
            margin: 5px 0;
            color: #555;
        }

        .hindi-text {
            font-family: 'Noto Sans Devanagari', sans-serif;
            font-weight: 700;
            display: block;
        }

        /* LOGO PLACEHOLDERS */
        .logo-box {
            width: 70px;
            height: 70px;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .logo-box img {
            max-width: 100%;
            max-height: 100%;
        }

        /* STATUS BANNER */
        .status-banner {
            background-color: #e8f5e9;
            border: 1px solid #2e7d32;
            /* Official Green */
            color: #1b5e20;
            padding: 10px;
            text-align: center;
            font-size: 12pt;
            font-weight: bold;
            border-radius: 4px;
            margin-bottom: 25px;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 10px;
        }

        /* CONTENT GRID */
        .content-area {
            display: flex;
            gap: 20px;
        }

        .details-left {
            flex: 60%;
        }

        .photo-right {
            flex: 40%;
            display: flex;
            flex-direction: column;
            align-items: center;
            border-left: 1px dashed #ccc;
            padding-left: 20px;
        }

        /* DATA ROWS */
        .data-row {
            margin-bottom: 15px;
            border-bottom: 1px solid #eee;
            padding-bottom: 5px;
        }

        .label {
            font-size: 8pt;
            color: #666;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            margin-bottom: 3px;
        }

        .value {
            font-size: 11pt;
            font-weight: 600;
            color: #000;
        }

        .aadhaar-masked {
            font-family: 'Courier New', monospace;
            letter-spacing: 2px;
            font-weight: bold;
            font-size: 12pt;
        }

        /* IMAGES */
        .card-preview {
            width: 100%;
            max-width: 250px;
            border: 1px solid #ddd;
            padding: 5px;
            border-radius: 4px;
            background: #fafafa;
        }

        .card-preview img {
            width: 100%;
            display: block;
        }

        /* TRANSACTION FOOTER */
        .txn-footer {
            margin-top: 30px;
            background-color: #f1f8ff;
            border-left: 4px solid #005691;
            /* UIDAI Blue */
            padding: 15px;
            display: flex;
            justify-content: space-between;
            font-size: 9pt;
        }

        .txn-group strong {
            display: block;
            color: #005691;
            margin-bottom: 2px;
        }

        /* DISCLAIMER */
        .legal-footer {
            position: absolute;
            bottom: 15mm;
            left: 15mm;
            right: 15mm;
            text-align: center;
            font-size: 8pt;
            color: #888;
            border-top: 1px solid #ddd;
            padding-top: 10px;
        }
    </style>
</head>

<body>

    <div class="container">

        <div class="header">
            <div class="logo-box">
                <img src="https://upload.wikimedia.org/wikipedia/commons/5/55/Emblem_of_India.svg" alt="Emblem">
            </div>

            <div class="header-center">
                <span class="hindi-text" style="font-size: 14pt;">भारत सरकार</span>
                <h1>Government of India</h1>
                <span class="hindi-text" style="font-size: 10pt; color: #555; margin-top:5px;">भारतीय विशिष्ट पहचान
                    प्राधिकरण</span>
                <h2>Unique Identification Authority of India</h2>
                <div style="font-size: 10pt; font-weight: bold; margin-top: 5px; text-decoration: underline;">
                    Aadhaar Verification Receipt
                </div>
            </div>

            <div class="logo-box">
                <img src="https://upload.wikimedia.org/wikipedia/en/c/cf/Aadhaar_Logo.svg" alt="Aadhaar">
            </div>
        </div>

        <div class="status-banner">
            <span>&#10003;</span>
            Authentication Successful / <span class="hindi-text" style="margin-left:5px;">प्रमाणीकरण सफल</span>
        </div>

        <div class="content-area">

            <div class="details-left">
                <div class="data-row">
                    <div class="label">Resident Name / <span class="hindi-text" style="display:inline;">निवासी का
                            नाम</span></div>
                    <div class="value">{{ $name ?? 'PATEL CHAMANBEN' }}</div>
                </div>

                <div class="data-row">
                    <div class="label">Aadhaar Number / <span class="hindi-text" style="display:inline;">आधार
                            संख्या</span></div>
                    <div class="value aadhaar-masked">
                        {{ $aadhaar_number_masked ?? '4513 XXXX 0803' }}
                    </div>
                </div>

                <div class="data-row">
                    <div class="label">Authentication Method / <span class="hindi-text"
                            style="display:inline;">प्रमाणीकरण विधि</span></div>
                    <div class="value">
                        OTP (One Time Password) <span style="color:green; font-weight:bold;">&#10003; Verified</span>
                    </div>
                </div>

                <div class="data-row" style="border:none;">
                    <div class="label">Response Code / <span class="hindi-text" style="display:inline;">प्रतिक्रिया
                            कोड</span></div>
                    <div class="value"
                        style="font-family: monospace; font-size: 9pt; background: #f0f0f0; padding: 4px; border-radius: 3px; word-break: break-all;">
                        {{ $response_code ?? '96E164B006C32B98DB0A9A2ACE22FAAD' }}
                    </div>
                </div>
            </div>

            <div class="photo-right">
                <div class="label" style="width: 100%; text-align: center;">ID Card Image / <span class="hindi-text"
                        style="display:inline;">पहचान पत्र</span></div>

                <div class="card-preview">
                    @if (!empty($aadhar_card_image))
                        <img src="data:{{ $aadhar_card_image_mime }};base64,{{ $aadhar_card_image }}"
                            alt="Aadhaar Card">
                    @else
                        <div
                            style="height:150px; display:flex; align-items:center; justify-content:center; color:#ccc;">
                            Image Not Available
                        </div>
                    @endif
                </div>

                <div
                    style="margin-top: 10px; font-size: 8pt; color: green; font-weight: bold; border: 1px solid green; padding: 2px 8px; border-radius: 10px;">
                    [ VERIFIED ]
                </div>
            </div>

        </div>

        <div class="txn-footer">
            <div class="txn-group">
                <strong>Transaction ID</strong>
                {{ $transaction_id ?? '44138419' }}
            </div>
            <div class="txn-group">
                <strong>Date / <span class="hindi-text" style="display:inline;">दिनांक</span></strong>
                {{ $verification_date ?? '05/12/2025' }}
            </div>
            <div class="txn-group">
                <strong>Time / <span class="hindi-text" style="display:inline;">समय</span></strong>
                {{ $verification_time ?? '04:23:44' }}
            </div>
        </div>

        <div class="legal-footer">
            This is a computer-generated receipt. / <span class="hindi-text" style="display:inline;">यह एक कंप्यूटर जनित
                रसीद है।</span><br>
            © 2025 Unique Identification Authority of India
        </div>

    </div>
</body>

</html> --}}
