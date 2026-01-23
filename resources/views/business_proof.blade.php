@extends('layouts.app')

@section('styles')
    <link rel="stylesheet" href="{{ asset('css/common_header.css') }}">
    <link rel="stylesheet" href="{{ asset(path: 'css/business_proof.css') }}">
    <link rel="stylesheet" href="{{ asset('css/footer.css') }}">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
@endsection

@section('content')
    @include('layouts.common_header')

    <section class="banner-wrapper">
        <div class="banner-image">
            <img src="../images/business_proof.png" alt="Banner" class="img-fluid w-100">
        </div>
    </section>

    <section class="section-wrapper business_proof_wrapper">
        <div class="container">
            <div class="section-title">
                <h1>Select Your Business Category</h1>
                <p>Choose the category that best describes your professional status to proceed with
                    verification</p>
            </div>

            <div class="cards-grid">
                <div class="card">
                    <div class="icon-wrapper">
                        <div class="icon">
                            <i class="fa-solid fa-briefcase"></i>
                        </div>
                    </div>
                    <h3 class="card-title">Salaried</h3>
                    <p class="card-description">Full-time employees with regular monthly income from an employer</p>
                    <a href="{{ route('salaried_proof') }}" class="select-link" data-bs-toggle="modal" data-bs-target="#exampleModal">
                        Select <span class="arrow">→</span></a>
                </div>

                <div class="card">
                    <div class="icon-wrapper">
                        <div class="icon">
                            <i class="fa-solid fa-user"></i>
                        </div>
                    </div>
                    <h3 class="card-title">Self-Employed</h3>
                    <p class="card-description">Business owners and entrepreneurs running their own ventures</p>
                    <a href="#" class="select-link">
                        Select <span class="arrow">→</span>
                    </a>
                </div>

                <div class="card">
                    <div class="icon-wrapper">
                        <div class="icon">
                            <i class="fa-solid fa-laptop"></i>
                        </div>
                    </div>
                    <h3 class="card-title">Freelancer</h3>
                    <p class="card-description">Independent professionals working on project-based assignments</p>
                    <a href="#" class="select-link">
                        Select <span class="arrow">→</span>
                    </a>
                </div>

                <div class="card">
                    <div class="icon-wrapper">
                        <div class="icon">
                            <i class="fa-solid fa-person-cane"></i>
                        </div>
                    </div>
                    <h3 class="card-title">Pensioner</h3>
                    <p class="card-description">Retired individuals receiving regular pension or retirement benefits</p>
                    <a href="#" class="select-link">
                        Select <span class="arrow">→</span>
                    </a>
                </div>
            </div>
        </div>
    </section>

    @include('layouts.footer')

@endsection

<div class="modal fade custom_bussiness_type_modal" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg modal-dialog-centered modal-dialog-scrollable">
    <div class="modal-content">
      <div class="modal-header">
        <h1 class="modal-title fs-5" id="exampleModalLabel">Salaried Business Proof</h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
         <div class="business_box">

                {{-- <div class="title">
                    <h2>Salaried Business Proof</h2>
                    <p>Select and upload your business registration documents</p>
                </div> --}}

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
            </div>
      </div>
      <div class="modal-footer">
        <div class="business_box_btn">
                    <button class="btn-cancel">Cancel</button>
                    <button class="btn-submit">Save & Continue</button>
                </div>
      </div>
    </div>
  </div>
</div>

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
<script src="{{ asset('js/business_proof.js') }}"></script>

@endpush
