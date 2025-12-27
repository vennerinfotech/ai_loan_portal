@extends('layouts.app')

@section('styles')
    <link rel="stylesheet" href="{{ asset('css/aadhaar_data_review.css') }}">
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
@endsection

@section('content')
    <div class="form-container-wrapper">
        <div class="container">
            <div class="form-container">
                <div class="left-section">
                    <div class="content">
                        <img src="{{ asset('images/logo-1.png') }}" alt="Logo" class="logo-image">
                        <div class="info">
                            <h4>Secure Verification</h4>
                            <p>Your Aadhaar details are encrypted with industry-standard protocols ensuring complete privacy
                                and security.</p>
                        </div>

                    </div>
                </div>
                <div class="form-card">
                    <div class="review-container w-100">
                        <div class="text-center mb-4" id="formHeader">
                             <div class="icon-circle mx-auto">
                            <i class="bi bi-file-earmark-person-fill" style="font-size: 1.5rem;"></i>
                        </div>

                            <h3 class="mt-3">Review Your Aadhaar Details</h3>
                            <p class="text-muted">Please verify and confirm your information before proceeding</p>
                        </div>

                        <div id="successMessage" class="text-center review-card">
                            <div class="header-icon" style="background-color: #e6ffed; color: #198754;">
                                <i class="bi bi-check-circle-fill" style="font-size: 1.5rem;"></i>
                            </div>
                            <h4 class="fw-bold mb-2" style="color: #198754;">Submission Successful! 🎉</h4>
                            <p class="text-muted">Your Aadhaar details have been successfully verified and submitted for
                                processing.
                            </p>
                            <button class="btn btn-primary mt-3" onclick="resetForm()">Go Back to Dashboard</button>
                        </div>

                        <div class="review-card">
                            @if (!$document || (!$user && !$customer && !$extracted))
                                <div class="alert alert-warning">
                                    <i class="bi bi-exclamation-triangle"></i>
                                    <strong>No Aadhaar data found.</strong> Please upload your Aadhaar card first.
                                    <br><br>
                                    <a href="{{ route('enter-aadhaar') }}" class="btn btn-primary">Upload Aadhaar Card</a>
                                </div>
                            @else
                                <form id="aadhaarForm">

                                    @php
                                        // Get real data from user/customer or extracted data
                                        $fullName =
                                            $user->name ??
                                            (null ??
                                                ($customer->name ?? (null ?? ($extracted['name'] ?? (null ?? 'N/A')))));
                                        $dob =
                                            $user->date_of_birth ??
                                            (null ??
                                                ($customer->date_of_birth ??
                                                    (null ?? ($extracted['date_of_birth'] ?? (null ?? 'N/A')))));
                                        $address =
                                            $user->address ??
                                            (null ??
                                                ($customer->address ??
                                                    (null ?? ($extracted['address'] ?? (null ?? 'N/A')))));
                                        $gender =
                                            $user->gender ??
                                            (null ??
                                                ($customer->gender ??
                                                    (null ?? ($extracted['gender'] ?? (null ?? 'N/A')))));
                                        $phone =
                                            $user->phone ??
                                            (null ??
                                                ($customer->phone ??
                                                    (null ?? ($extracted['phone'] ?? (null ?? 'N/A')))));
                                        $email =
                                            $user->email ??
                                            (null ??
                                                ($customer->email ??
                                                    (null ?? ($extracted['email'] ?? (null ?? 'N/A')))));
                                        $aadhaarNumber = $document->aadhar_card_number ?? (null ?? 'N/A');

                                        // Format Aadhaar number (mask it)
                                        $maskedAadhaar = 'N/A';
                                        if ($aadhaarNumber && $aadhaarNumber !== 'N/A' && strlen($aadhaarNumber) >= 8) {
                                            $maskedAadhaar =
                                                substr($aadhaarNumber, 0, 4) . ' XXXX ' . substr($aadhaarNumber, -4);
                                        }

                                        // Format DOB
                                        $dobFormatted = 'N/A';
                                        if ($dob && $dob !== 'N/A') {
                                            try {
                                                if (is_string($dob) && strpos($dob, '/') !== false) {
                                                    // Format: DD/MM/YYYY
                                                    $dobParts = explode('/', $dob);
                                                    if (count($dobParts) == 3) {
                                                        $dob = $dobParts[0] . '-' . $dobParts[1] . '-' . $dobParts[2];
                                                    }
                                                }
                                                $dobFormatted = \Carbon\Carbon::parse($dob)->format('Y-m-d');
                                            } catch (\Exception $e) {
                                                $dobFormatted = $dob;
                                            }
                                        }
                                    @endphp

                                    <div class="form-group">
                                        <label for="fullName" class="form-label">Full Name</label>
                                        <div class="input-group-field">
                                            <input type="text" class="form-control" id="fullName"
                                                value="{{ $fullName }}" readonly>
                                            <i class="bi bi-person input-icon"></i>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label for="dob" class="form-label">Date of Birth</label>
                                        <div class="input-group-field">
                                            <input type="text" class="form-control" id="dob"
                                                value="{{ $dobFormatted }}" readonly>
                                            <i class="bi bi-calendar input-icon"></i>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label for="address" class="form-label">Address</label>
                                        <div class="input-group-field">
                                            <textarea class="form-control" id="address" rows="3" readonly>{{ $address }}</textarea>
                                            <i class="bi bi-geo-alt input-icon textarea-icon"></i>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label for="gender" class="form-label">Gender</label>
                                        <select class="form-select" id="gender" disabled>
                                            <option value="Male"
                                                {{ $gender == 'Male' || $gender == 'M' || $gender == 'MALE' ? 'selected' : '' }}>
                                                Male
                                            </option>
                                            <option value="Female"
                                                {{ $gender == 'Female' || $gender == 'F' || $gender == 'FEMALE' ? 'selected' : '' }}>
                                                Female</option>
                                            <option value="Other"
                                                {{ $gender != 'Male' && $gender != 'Female' && $gender != 'M' && $gender != 'F' && $gender != 'MALE' && $gender != 'FEMALE' && $gender != 'N/A' ? 'selected' : '' }}>
                                                Other</option>
                                        </select>
                                    </div>

                                    <div class="form-group">
                                        <label for="phone" class="form-label">Phone Number</label>
                                        <div class="input-group-field">
                                            <input type="text" class="form-control" id="phone"
                                                value="{{ $phone }}" readonly>
                                            <i class="bi bi-phone input-icon"></i>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label for="email" class="form-label">Email Address</label>
                                        <div class="input-group-field">
                                            <input type="email" class="form-control" id="email"
                                                value="{{ $email }}" readonly>
                                            <i class="bi bi-envelope input-icon"></i>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label for="aadhaar" class="form-label">Aadhaar Number</label>
                                        <div class="input-group-field">
                                            <input type="text" class="form-control" id="aadhaar"
                                                value="{{ $maskedAadhaar }}" readonly>
                                            <i class="bi bi-lock input-icon"></i>
                                        </div>
                                        <small class="text-muted mt-1 d-block" style="font-size: 0.8rem;">Aadhaar number
                                            is masked for
                                            security</small>
                                    </div>

                                    <div class="verification-notice mb-4">
                                        <i class="bi bi-info-circle-fill"></i>
                                        <div>
                                            <p class="mb-0">Verification Notice</p>
                                            <span class="d-block">By confirming, you agree that the information provided is accurate and complete. This data will be used for identity verification purposes only.</span>
                                        </div>
                                    </div>
                                    <a href="{{ route('aadhaar_verification_comp') }}"
                                            class="btn-submit">
                                            Confirm & Submit
                                        </a>

                                   <button type="button"
                                            class="btn-cancel"
                                            onclick="handleBack()">
                                            <i class="bi bi-arrow-left" style="margin-right: 5px;"></i>
                                            Back to Edit
                                        </button>


                                </form>
                            @endif
                        </div>
                        <div class="text-center security-footer" id="securityFooter">
                            <i class="bi bi-shield-lock-fill" style="margin-right: 5px; color: #198754;"></i>
                            Your data is encrypted and secure
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script src="{{ asset('js/aadhaar_verification_comp.js') }}"></script>
@endpush
