<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});


// Route::get('/register', function () {
//     return view('auth.register');
// })->name('register');


//  Registration Page
Route::get('/register', function () {
    return view('auth.register');
})->name('register');

//  OTP Page
Route::get('/verify_otp', function (Request $request) {
    return view('auth.verify_otp');
})->name('verify.otp');

// create a MPIN page
Route::get('/MPIN', function () {
    return view('mpin');
})->name('mpin');

//  Dashboard (after MPIN create successfully)
Route::get('/dashboard', function () {
    return view('dashboard');
})->name('dashboard');

// Aadhaarcard verification
Route::get('/enter-aadhaar', function () {
    return view('aadhaar');
})->name('enter-aadhaar');

Route::get('/aadhaar_verify_otp', function () {
    return view('verify_aadhaar');
})->name('aadhaar_verify_otp');

Route::get('/upload_aadhaar_document', function () {
    return view('upload_aadhaar_document');
})->name('upload_aadhaar_doc');

Route::get('/aadhaar_data_review', function () {
    return view('aadhaar_data_review');
})->name('aadhaar1');

Route::get('/aadhaar_verification_completed', function () {
    return view('aadhaar_verification_comp');
})->name('aadhaar_verification_comp');


// Pancard verification
Route::get('/enter-pan', function () {
    return view('pan');
})->name('pan');

Route::get('/verify_pan_number', action: function () {
    return view('Verify_pan');
})->name('Verify_pan');

Route::get('/upload_pan_document', action: function () {
    return view('upload_pan_document');
})->name('Verify_pan');

Route::get('/pan_data_review', action: function () {
    return view('pan_data_review');
})->name('pan_data_review');

Route::get('/pan_verification_completed', action: function () {
    return view('pan_verification_comp');
})->name('pan_verification_comp');

Route::get('/cibil_credit_report', action: function () {
    return view('cibil_crif');
})->name('cibil_crifr');

Route::get('/verify_cibil_credit_scores', action: function () {
    return view('verify_cibil_credit');
})->name('verify_cibil_credit');

Route::get('/cibil_credit_score_report', action: function () {
    return view('cibil_credit_score');
})->name('cibil_credit_score');

Route::get('/final_confirmation', action: function () {
    return view('verify_cibil_credit_score');
})->name('cibil_crif');

// apply for loan
Route::get('/apply_for_loan ', action: function () {
    return view('apply_loan');
})->name('apply_loan');

// Loan Offers Page
Route::get('/loan_offers', function () {
    return view('loan_offers');
})->name('loan.offers');

Route::get('/aa', function () {
    return view('aa');
})->name('aa');

