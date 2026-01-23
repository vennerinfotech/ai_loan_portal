<?php

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\AadhaarController;
use App\Http\Controllers\BusinessProofController;
use App\Http\Controllers\PancardController;
use App\Http\Controllers\UserSettingController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    if (Illuminate\Support\Facades\Auth::check()) {
        return redirect()->route('dashboard');
    }
    return view('welcome', ['showHeader' => true]);
});

Route::get('/register', [RegisterController::class, 'create'])->name('register.create');
Route::post('/register', [RegisterController::class, 'store'])->name('register.store');
Route::get('/change-number', [RegisterController::class, 'changeNumber'])->name('register.change_number');

route::get('/verify_otp', [RegisterController::class, 'show_verify_otp'])->name('verify.otp');
Route::post('/verify-otp', [RegisterController::class, 'verifyOtp'])->name('otp.verify');
Route::post('/resend-otp', [RegisterController::class, 'resendOtp'])->name('otp.resend');

route::get('/MPIN', [RegisterController::class, 'show_mpin'])->name('mpin');
Route::post('/mpin', [RegisterController::class, 'store_mpin'])->name('mpin.store');

Route::get('/Forgot_MPIN', [RegisterController::class, 'forgot_mpin'])->name('forgot_mpin');
Route::post('/forgot-mpin-otp', [RegisterController::class, 'sendForgotMpinOtp'])->name('forgot_mpin.send_otp');
Route::get('/forgot-mpin-verify', [RegisterController::class, 'showForgotMpinVerifyOtp'])->name('forgot_mpin.verify_otp');
Route::post('/forgot-mpin-verify', [RegisterController::class, 'verifyForgotMpinOtp'])->name('forgot_mpin.verify_otp.post');
Route::post('/forgot-mpin-resend', [RegisterController::class, 'resendForgotMpinOtp'])->name('forgot_mpin.resend_otp');
Route::get('/reset-mpin', [RegisterController::class, 'showResetMpin'])->name('reset.mpin.view');
Route::post('/reset-mpin', [RegisterController::class, 'storeNewMpin'])->name('reset.mpin.store');

Route::get('/dashboard', [RegisterController::class, 'showDashboard'])->name('dashboard');

Route::get('/business_proof', [BusinessProofController::class, 'business_proof'])->name('business_proof');
Route::get('/salaried_proof', [BusinessProofController::class, 'salaried_proof'])->name('salaried_proof');

route::get('/login', [LoginController::class, 'create'])->name('login');
Route::post('/login', [LoginController::class, 'authenticate'])->name('login.authenticate');
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

route::get('/enter-aadhaar', [AadhaarController::class, 'create'])->name('enter-aadhaar');
Route::post('/store-aadhaar', [AadhaarController::class, 'store'])->name('store-aadhaar');

route::get('/aadhaar_verify_otp', [AadhaarController::class, 'showOtpForm'])->name('aadhaar_verify_otp');
Route::post('/verify-aadhaar-otp', [AadhaarController::class, 'verifyOtp'])->name('aadhaar.verify.otp');
Route::post('/aadhaar-resend-otp', [AadhaarController::class, 'resendOtp'])->name('aadhaar.resend_otp');

route::get('/upload_aadhaar_document', [AadhaarController::class, 'uploadaadhaarform'])->name('upload_aadhaar_doc');
Route::post('/upload-aadhaar', [AadhaarController::class, 'uploadAadhaarDocument'])->name('upload.aadhaar.store');

route::get('/aadhaar_data_review', [AadhaarController::class, 'aadhaar_data_review'])->name('aadhaar1');
route::get('/aadhaar_verification_completed', [AadhaarController::class, 'aadhaar_verification_form'])->name('aadhaar_verification_comp');

route::get('/aadhar_not_linked', [AadhaarController::class, 'aadhar_not_linked'])->name('aadhar_not_linked');

// Route to download Aadhaar verification receipt
Route::get('/download-verification-receipt', [AadhaarController::class, 'downloadReceipt'])->name('aadhaar.downloadReceipt');

Route::get('/applicant_detail', [AadhaarController::class, 'applicant'])->name('applicant_detail');

Route::get('/input_loan_amount', [AadhaarController::class, 'inputloan'])->name('input_loan_amount');

// Test OCR Route (for testing only)
Route::get('/test-ocr', function () {
    return view('test_ocr');
})->name('test.ocr');
Route::post('/test-ocr', function (\Illuminate\Http\Request $request) {
    $request->validate([
        'aadhaar_image' => 'required|mimes:jpg,png,pdf|max:10240',
    ]);

    if ($request->hasFile('aadhaar_image')) {
        $file = $request->file('aadhaar_image');
        $filename = 'test_aadhaar_' . time() . '.' . $file->getClientOriginalExtension();
        $path = $file->storeAs('private_uploads/aadhar_card', $filename);

        $imagePath = storage_path('app/private_uploads/aadhar_card/' . $filename);

        $service = new \App\Services\AadhaarExtractionService;
        $result = $service->extractFromImage($imagePath);

        return view('test_ocr', ['result' => $result, 'image' => $filename]);
    }

    return back()->with('error', 'Please upload an image');
})->name('test.ocr.post');

route::get('/enter-pan', [PancardController::class, 'showpanform'])->name('pan');
// Route::post('/verify-pan-otp', [PancardController::class, 'verifyOtp'])->name('verify.pan.otp');
route::get('/upload_pan_document', [PancardController::class, 'upload_pan_document'])->name('Verify_pan');
route::post('/upload-pan', [PancardController::class, 'uploadPanDocument'])->name('upload.pan.store');
Route::post('/store-pan-card', [PancardController::class, 'store'])->name('pancard.store');
route::get('/verify_pan_number', [PancardController::class, 'Verify_pancard_form'])->name('Verify_pan');
route::get('/pan_data_review', [PancardController::class, 'pan_data_reviewform'])->name('pan_data_review');
route::get('/pan_verification_completed', [PancardController::class, 'pan_verification_comp'])->name('pan_verification_comp');
route::get('/pan_not_linked', [PancardController::class, 'pan_not_linked'])->name('pan_not_linked');

route::get('/user_setting', [UserSettingController::class, 'user_setting'])->name('user_setting');
Route::get('/change-mpin', [UserSettingController::class, 'showChangeMpin'])->name('change.mpin');
Route::post('/change-mpin', [UserSettingController::class, 'updateMpin'])->name('change.mpin.store');
Route::post('/update-profile-photo', [UserSettingController::class, 'updateProfilePhoto'])->name('update.profile.photo');
Route::post('/update-personal-info', [UserSettingController::class, 'updatePersonalInfo'])->name('update.personal.info');

// Route::get('/register', function () {
//     return view('auth.register');
// })->name('register');

//  Registration Page
// Route::get('/register', function () {
//     return view('auth.register');
// })->name('register');

//  OTP Page
// Route::get('/verify_otp', function (Request $request) {
//     return view('auth.verify_otp');
// })->name('verify.otp');

// create a MPIN page
// Route::get('/MPIN', function () {
//     return view('mpin');
// })->name('mpin');

// Route to handle MPIN submission

// Route::get('/login', function (Request $request) {
//     return view('auth.login');
// })->name('login');

//  Dashboard (after MPIN create successfully)
// Route::get('/dashboard', function () {
//     return view('dashboard');
// })->name('dashboard');
// Aadhaarcard verification

// Route::get('/enter-aadhaar', function () {
//     return view('aadhaar');
// })->name('enter-aadhaar');

// Route::get('/aadhaar_verify_otp', function () {
//     return view('verify_aadhaar');
// })->name('aadhaar_verify_otp');

// Route::get('/upload_aadhaar_document', function () {
//     return view('upload_aadhaar_document');
// })->name('upload_aadhaar_doc');

// Route::get('/aadhaar_data_review', function () {
//     return view('aadhaar_data_review');
// })->name('aadhaar1');

// Route::get('/aadhaar_verification_completed', function () {
//     return view('aadhaar_verification_comp');
// })->name('aadhaar_verification_comp');

// Pancard verification
// Route::get('/enter-pan', function () {
//     return view('pan');
// })->name('pan');

// Route::get('/verify_pan_number', action: function () {
//     return view('Verify_pan');
// })->name('Verify_pan');

// Route::get('/upload_pan_document', action: function () {
//     return view('upload_pan_document');
// })->name('Verify_pan');

// Route::get('/pan_data_review', action: function () {
//     return view('pan_data_review');
// })->name('pan_data_review');

// Route::get('/pan_verification_completed', action: function () {
//     return view('pan_verification_comp');
// })->name('pan_verification_comp');

Route::get('/cibil_credit_report', action: function () {
    $user = Illuminate\Support\Facades\Auth::user();
    $panNumber = $user->pan_card_number ?? ($user->customer->pan_card_number ?? 'N/A');

    // If not in DB, check session (optional fallback)
    if ($panNumber === 'N/A' || !$panNumber) {
        $sessionData = session('pan_extracted_data');
        if (isset($sessionData['pan_number'])) {
            $panNumber = $sessionData['pan_number'];
        }
    }

    return view('cibil_crif', ['panNumber' => $panNumber]);
})->name('cibil_crifr');

Route::get('/verify_cibil_credit_scores', action: function () {
    return view('verify_cibil_credit');
})->name('verify_cibil_credit');

Route::get('/cibil_credit_score_report', action: function () {
    $user = Illuminate\Support\Facades\Auth::user();
    $panNumber = $user->pan_card_number ?? ($user->customer->pan_card_number ?? 'N/A');

    // Fallback to session if N/A
    if ($panNumber === 'N/A' || !$panNumber) {
        $sessionData = session('pan_extracted_data');
        if (isset($sessionData['pan_number'])) {
            $panNumber = $sessionData['pan_number'];
        }
    }

    $score = 750;  // Default fallback
    $provider = 'CIBIL';
    $reportDate = now()->format('M d, Y');

    // Try to fetch real/mocked score
    if ($panNumber !== 'N/A' && $panNumber) {
        try {
            // Check if we have a stored score in the specific document
            // $document = \App\Models\Document::where('pan_card_number', $panNumber)->latest()->first();
            // if ($document && $document->cibil_score) {
            //    $score = $document->cibil_score;
            // } else {
            $service = new \App\Services\CibilScoreService;
            $result = $service->fetchCibilScore($panNumber);
            if ($result['success']) {
                $score = $result['data']['cibil_score'];
                $provider = $result['data']['provider'];
            }
            // }
        } catch (\Exception $e) {
            // Keep default
        }
    }

    return view('cibil_credit_score', [
        'score' => $score,
        'panNumber' => $panNumber,
        'reportDate' => $reportDate,
        'provider' => $provider,
    ]);
})->name('cibil_credit_score');

Route::get('/download-cibil-report', [PancardController::class, 'downloadFullReport'])->name('cibil.download.report');

Route::get('/final_confirmation', action: function () {
    return view('verify_cibil_credit_score');
})->name('cibil_crif');

// apply for loan
Route::get('/apply_for_loan', action: function () {
    return view('apply_loan');
})->name('apply_loan');

Route::get('/aa', function () {
    return view('aa');
})->name('aa');

// Document Locker Route
Route::get('/my-documents', [App\Http\Controllers\DocumentController::class, 'index'])->name('my-documents');
Route::get('/my-documents/{type}', [App\Http\Controllers\DocumentController::class, 'show'])->name('my-documents.show');
Route::get('/my-documents/{type}/pdf', [App\Http\Controllers\DocumentController::class, 'showPdf'])->name('my-documents.pdf');
Route::get('/document-image/{type}/{filename}', [App\Http\Controllers\DocumentController::class, 'serveImage'])->name('document.image');
