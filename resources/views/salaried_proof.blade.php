@extends('layouts.app')

@section('styles')
    <link rel="stylesheet" href="{{ asset('css/common_header.css') }}">
    <link rel="stylesheet" href="{{ asset('css/footer.css') }}">
    <link rel="stylesheet" href="{{ asset('css/business_proof_type.css') }}">
@endsection

@section('content')
    @include('layouts.common_header')

    <section class="business_proof_type">
        <div class="container">
            <div class="business_box">

                <div class="title">
                    <h2>Salaried Business Proof</h2>
                    <p>Select and upload your business registration documents</p>
                </div>

                <div class="business_box_inner">

                    <!-- Option 1 -->
                    <div class="upload_card active">
                        <label class="upload_header custom-checkbox">
                            <input type="checkbox" checked />
                            <span class="checkmark"></span>
                            <span class="checkbox-title">Form 16 or ITR</span>
                        </label>

                        <div class="upload_area">
                            <div class="upload_icon">
                                <i class="fa-solid fa-cloud-arrow-up"></i>
                            </div>
                            <p>Drop files here or click to upload</p>
                            <small>PDF, JPG, PNG (Max 5MB)</small>
                            <button type="button">Choose File</button>
                        </div>
                    </div>

                    <!-- Option 2 -->
                    <div class="upload_card">
                        <label class="upload_header custom-checkbox">
                            <input type="checkbox" />
                            <span class="checkmark"></span>
                            <span class="checkbox-title">Latest Salary Slips</span>
                        </label>

                        <div class="upload_area">
                            <div class="upload_icon">
                                <i class="fa-solid fa-cloud-arrow-up"></i>
                            </div>
                            <p>Drop files here or click to upload</p>
                            <small>PDF, JPG, PNG (Max 5MB)</small>
                            <button type="button">Choose File</button>
                        </div>
                    </div>

                    <!-- Option 3 -->
                    <div class="upload_card">
                        <label class="upload_header custom-checkbox">
                            <input type="checkbox" />
                            <span class="checkmark"></span>
                            <span class="checkbox-title">Salary Letterpad</span>
                        </label>

                        <div class="upload_area">
                            <div class="upload_icon">
                                <i class="fa-solid fa-cloud-arrow-up"></i>
                            </div>
                            <p>Drop files here or click to upload</p>
                            <small>PDF, JPG, PNG (Max 5MB)</small>
                            <button type="button">Choose File</button>
                        </div>
                    </div>

                </div>
                <div class="business_box_btn">
                    <button class="btn-cancel">Cancel</button>
                    <button class="btn-submit">Save & Continue</button>
                </div>
            </div>
        </div>
    </section>
    @include('layouts.footer')
@endsection

@push('scripts')
<script src="{{ asset('js/business_proof.js') }}"></script>
@endpush
