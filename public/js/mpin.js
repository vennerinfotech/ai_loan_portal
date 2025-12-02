// Function to combine individual input fields into a single 6-digit string
function getMPIN(prefix) {
    let mpin = "";
    for (let i = 1; i <= 6; i++) {
        mpin += document.getElementById(`${prefix}-${i}`).value;
    }
    return mpin;
}

// Checks for sequential numbers (e.g., 123456, 654321)
function isSequential(num) {
    const seqAsc = "123456";
    const seqDesc = "654321";
    return num === seqAsc || num === seqDesc;
}

// Checks for repeated digits (e.g., 111111, 222222)
function isRepeated(num) {
    return /^(\d)\1+$/.test(num);
}

// Real-Time Requirements Update Function
function updateRequirements() {
    const mpin = getMPIN("mpin");

    // 1. Length Requirement (Must be exactly 6 digits)
    const lengthValid = mpin.length === 6;
    updateIcon('req-length', lengthValid);

    // 2. Sequential Requirement (Avoid sequential)
    const sequentialValid = !isSequential(mpin);
    if (mpin.length === 6) {
        updateIcon('req-sequential', sequentialValid);
    } else {
        // Keep red until 6 digits are entered
        updateIcon('req-sequential', false, true);
    }

    // 3. Repeated Requirement (Avoid repeated)
    const repeatedValid = !isRepeated(mpin);
    if (mpin.length === 6) {
        updateIcon('req-repeated', repeatedValid);
    } else {
        // Keep red until 6 digits are entered
        updateIcon('req-repeated', false, true);
    }
}

// Helper function to update the icon (✅ or ❌)
function updateIcon(elementId, isValid, forceCross = false) {
    const li = document.getElementById(elementId);
    if (!li) return;

    let icon = li.querySelector('i');
    if (!icon) {
        icon = document.createElement('i');
        li.prepend(icon);
    }

    if (isValid && !forceCross) {
        icon.className = 'bi bi-check-lg text-success me-1';
    } else {
        icon.className = 'bi bi-x-lg text-danger me-1';
    }
}


// MPIN Generation and Validation Logic (Swal.fire used here)
function generateMPIN() {
    const mpin = getMPIN("mpin");
    const confirm = getMPIN("cmpin");

    // Re-run the requirement check before final submission
    updateRequirements();

    if (mpin.length !== 6 || confirm.length !== 6) {
        Swal.fire({
            icon: 'warning',
            title: 'Incomplete MPIN',
            text: 'Please enter a complete 6-digit MPIN in both fields.',
            confirmButtonColor: '#7b62ff'
        });
        return;
    }

    if (mpin !== confirm) {
        Swal.fire({
            icon: 'error',
            title: 'MPIN Mismatch',
            text: 'The MPIN and Confirm MPIN do not match!',
            confirmButtonColor: '#d33'
        });
        return;
    }

    if (isSequential(mpin)) {
        Swal.fire({
            icon: 'error',
            title: 'Unsafe MPIN',
            text: 'MPIN should not be sequential (e.g., 123456 or 654321).',
            confirmButtonColor: '#d33'
        });
        return;
    }

    if (isRepeated(mpin)) {
        Swal.fire({
            icon: 'error',
            title: 'Unsafe MPIN',
            text: 'MPIN should not contain repeated digits (e.g., 111111).',
            confirmButtonColor: '#d33'
        });
        return;
    }

    // Success Pop-up
    Swal.fire({
        icon: 'success',
        title: 'MPIN Generated Successfully!',
        text: 'Your secure 6-digit MPIN has been set.',
        confirmButtonColor: '#28a745'
    }).then(() => {
        Optional: "Redirect or perform next action here..";
        window.location.href = "/dashboard";
    });
}


// Auto-Focus/Auto-Tab Logic
function handleInput(e) {
    const input = e.target;
    const isMPINInput = input.id.startsWith('mpin');

    // Call the real-time update function only for the main MPIN entry
    if (isMPINInput) {
        updateRequirements();
    }

    // Auto-focus next input field on successful entry
    if (input.value && input.value.length === input.maxLength) {
        let next = input.nextElementSibling;
        while (next && next.tagName !== 'INPUT') {
            next = next.nextElementSibling;
        }
        if (next) {
            next.focus();
        }
    }

    // Auto-focus previous input field on backspace/delete
    if (e.inputType === 'deleteContentBackward' && input.value.length === 0) {
        let prev = input.previousElementSibling;
        while (prev && prev.tagName !== 'INPUT') {
            prev = prev.previousElementSibling;
        }
        if (prev) {
            prev.focus();
        }
    }
}

// Setup function to attach event listeners
function setupAutoTab() {
    const mpinInputs = document.querySelectorAll('.mpin-box');

    mpinInputs.forEach(input => {
        input.addEventListener('input', handleInput);

        // Prevent non-numeric key presses
        input.addEventListener('keydown', (e) => {
            if (e.key.length === 1 && isNaN(parseInt(e.key)) && e.key !== ' ' && e.key !== '.' && e.key !== ',') {
                if (!e.ctrlKey && !e.altKey && !e.metaKey) {
                    e.preventDefault();
                }
            }
        });
    });
    // Initial check to ensure requirements are visible (all crosses initially)
    updateRequirements();
}

document.addEventListener('DOMContentLoaded', setupAutoTab);
