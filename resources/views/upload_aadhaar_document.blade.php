@extends('layouts.app')

@section('styles')
    <link rel="stylesheet" href="{{ asset('css/upload_aadhaar_doc.css') }}">
@endsection

@section('body-class', 'aadhaar')

@section('content')
    <div class="upload-card aadhaar">
        <div class="text-center mb-4">
            <div class="icon-box mx-auto mb-2">
                <i class="bi bi-file-earmark-text"></i>
            </div>
            <h5 class="fw-bold mb-1">Upload Aadhaar Document</h5>
            <p class="upload-description">Please upload a clear copy of your Aadhaar card for verification</p>
        </div>

        <!-- Form to upload the Aadhaar card -->
        <form action="{{ route('upload.aadhaar.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="secondary-card mb-4">
                <div class="upload-area mb-3" id="uploadArea">
                    <i class="bi bi-camera"></i>
                    <p>Tap to take photo<br>or upload from gallery</p>
                </div>

                <div class="d-flex gap-2">
                    <button type="button" class="btn btn-primary w-50" id="takePhotoBtn"><i
                            class="bi bi-camera-fill me-1"></i>Take Photo</button>
                    <button type="button" class="btn btn-light w-50" id="uploadFromGalleryBtn"><i
                            class="bi bi-folder-fill me-1"></i>Gallery</button>
                    <!-- Hidden File Input for Gallery Upload -->
                    <input type="file" name="aadhaar_card_image" id="fileInput" accept="image/*,application/pdf"
                        style="display:none" />
                </div>
            </div>

            <div class="secondary-card pt-3" id="imagePreviewBox" style="display: none;">
                <div class="mb-3">
                    <h6 class="fw-semibold">Image Preview</h6>
                    <div class="image-preview-box">
                        <img id="previewImage" src="" class="img-fluid" alt="Aadhaar Card Image">
                        <button type="button" id="removeImage" class="btn btn-danger btn-sm">
                            <i class="bi bi-x-circle"></i> Remove Image
                        </button>
                    </div>
                </div>
            </div>

            <div class="secondary-card pt-3">
                <div class="instructions mb-4">
                    <h6 class="fw-semibold mb-3"><i class="bi bi-info-circle-fill me-1"></i> Important Instructions</h6>
                    <ul class="list-unstyled">
                        <li class="mb-2">Ensure all four corners of the Aadhaar card are visible</li>
                        <li class="mb-2">Take photo in good lighting conditions</li>
                        <li class="mb-2">Avoid shadows and reflections on the card</li>
                        <li class="mb-2">Make sure text is clear and readable</li>
                    </ul>
                </div>

                <div class="sample-box mb-3">
                    <h4 class="fw-semibold mb-3"><i class="bi bi-image-alt me-1"></i> Sample Photo Reference</h4>
                    <div class="sample-img-box">
                        <img src="{{ asset('images/Sample.png') }}" class="img-fluid" alt="Sample Aadhaar Card Photo">
                        <p class="mt-2">Sample: Clear, well-lit Aadhaar card photo</p>
                    </div>
                </div>
            </div>

            <div class="format-info mb-3 ps-2">
                <p class="small mb-1"><i class="bi bi-lightning-charge-fill me-2"></i>Accepted formats: JPG, PNG, PDF</p>
                <p class="small"><i class="bi bi-arrow-up-circle-fill me-2"></i>Maximum size: 10 MB</p>
            </div>

            <div class="secure-box p-3 mb-4">
                <strong><i class="bi bi-shield-fill"></i>Secure Upload</strong>
                <p class="small mb-0">Your document is encrypted and stored securely. We use bank-level security to protect
                    your information.</p>
            </div>

            <div class="d-flex gap-3">
                <button type="button" class="btn btn-light border w-50">Cancel</button>
                <button type="submit" class="btn btn-success w-50">
                    Submit
                </button>
            </div>
        </form>
    </div>
@endsection

@push('scripts')
    <script src="{{ asset('js/upload_aadhaar_doc.js') }}"></script>
@endpush
