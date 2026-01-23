@extends('layouts.app')

@section('styles')
    <link rel="stylesheet" href="{{ asset('css/common_header.css') }}">
    <link rel="stylesheet" href="{{ asset(path: 'css/business_proof.css') }}">
    <link rel="stylesheet" href="{{ asset('css/footer.css') }}">
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
                    <a href="javascript:void(0)" class="select-link" data-bs-toggle="modal"
                        data-bs-target="#Salaried-modal">
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
                    <a href="javascript:void(0)" class="select-link" data-bs-toggle="modal"
                        data-bs-target="#Self-employee-modal">
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
                    <a href="javascript:void(0)" class="select-link" data-bs-toggle="modal"
                        data-bs-target="#Freelancer-modal">
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
                    <a href="javascript:void(0)" class="select-link" data-bs-toggle="modal"
                        data-bs-target="#Pensioner-modal">
                        Select <span class="arrow">→</span>
                    </a>
                </div>
            </div>
        </div>
    </section>

    @include('layouts.footer')

    <!-- Modal Salaried-->
    <div class="modal fade custom_bussiness_type_modal" id="Salaried-modal" tabindex="-1"
        aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="exampleModalLabel">Salaried Business Proof</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="business_box">
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
                        <button class="btn-submit">Save & Continue</button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Self-employee-->
    <div class="modal fade custom_bussiness_type_modal" id="Self-employee-modal" tabindex="-1"
        aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="exampleModalLabel">Self-Employed Business Proof</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="business_box">
                        <div class="business_box_inner">
                            <div class="upload_card active">
                                <label class="upload_header custom-checkbox">
                                    <input type="checkbox" checked />
                                    <span class="checkmark"></span>
                                    <span class="checkbox-title">GST Registration</span>
                                </label>

                                <div class="form-card">
                                    <div class="form-group">
                                        <label>PAN Number</label>
                                        <div class="fetch-input">
                                            <input type="text" class="form-control" placeholder="Enter PAN Number"
                                                id="Fetch-gst" name="Fetch-gst">
                                            <a href="#" class="fetch-gst-btn text-decoration-none">Fetch GST</a>
                                        </div>
                                        @error('phone')
                                            <div class="error-message text-danger">GST not found. Please upload document
                                                manually.</div>
                                        @enderror
                                    </div>
                                </div>

                                <div class="upload_area">
                                    <div class="upload_icon">
                                        <i class="fa-solid fa-cloud-arrow-up"></i>
                                    </div>
                                    <p>Drop files here or click to upload</p>
                                    <small>PDF, JPG, PNG (Max 5MB)</small>
                                    <button type="button">Choose File</button>
                                </div>
                            </div>
                            <div class="upload_card">
                                <label class="upload_header custom-checkbox">
                                    <input type="checkbox" />
                                    <span class="checkmark"></span>
                                    <span class="checkbox-title">Udyam Registration</span>
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
                            <div class="upload_card">
                                <label class="upload_header custom-checkbox">
                                    <input type="checkbox" />
                                    <span class="checkmark"></span>
                                    <span class="checkbox-title">MCA Pvt / Ltd</span>
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
                            <div class="upload_card">
                                <label class="upload_header custom-checkbox">
                                    <input type="checkbox" />
                                    <span class="checkmark"></span>
                                    <span class="checkbox-title">FSSAI License</span>
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
                            <div class="upload_card">
                                <label class="upload_header custom-checkbox">
                                    <input type="checkbox" />
                                    <span class="checkmark"></span>
                                    <span class="checkbox-title">EPFO</span>
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
                            <div class="upload_card">
                                <label class="upload_header custom-checkbox">
                                    <input type="checkbox" />
                                    <span class="checkmark"></span>
                                    <span class="checkbox-title">Gumasta</span>
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
                            <div class="upload_card">
                                <label class="upload_header custom-checkbox">
                                    <input type="checkbox" />
                                    <span class="checkmark"></span>
                                    <span class="checkbox-title">ISO + RC</span>
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
                            <div class="upload_card">
                                <label class="upload_header custom-checkbox">
                                    <input type="checkbox" />
                                    <span class="checkmark"></span>
                                    <span class="checkbox-title">Shop Act</span>
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
                            <div class="upload_card">
                                <label class="upload_header custom-checkbox">
                                    <input type="checkbox" />
                                    <span class="checkmark"></span>
                                    <span class="checkbox-title">Import–Export Code</span>
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
                            <div class="upload_card">
                                <label class="upload_header custom-checkbox">
                                    <input type="checkbox" />
                                    <span class="checkmark"></span>
                                    <span class="checkbox-title">PF Registration</span>
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
                            <div class="upload_card">
                                <label class="upload_header custom-checkbox">
                                    <input type="checkbox" />
                                    <span class="checkmark"></span>
                                    <span class="checkbox-title">Other</span>
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
                        <button class="btn-submit">Save & Continue</button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Freelancer-->
    <div class="modal fade custom_bussiness_type_modal" id="Freelancer-modal" tabindex="-1"
        aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="exampleModalLabel">Freelancer Business Proof</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="business_box">
                        <div class="business_box_inner">
                            <div class="upload_card active">
                                <label class="upload_header custom-checkbox">
                                    <input type="checkbox" checked />
                                    <span class="checkmark"></span>
                                    <span class="checkbox-title">Employment Certificate</span>
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
                            <div class="upload_card">
                                <label class="upload_header custom-checkbox">
                                    <input type="checkbox" />
                                    <span class="checkmark"></span>
                                    <span class="checkbox-title">Portfolio</span>
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
                            <div class="upload_card">
                                <label class="upload_header custom-checkbox">
                                    <input type="checkbox" />
                                    <span class="checkmark"></span>
                                    <span class="checkbox-title">Increment Letter</span>
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
                            <div class="upload_card">
                                <label class="upload_header custom-checkbox">
                                    <input type="checkbox" />
                                    <span class="checkmark"></span>
                                    <span class="checkbox-title">Invoice</span>
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
                            <div class="upload_card">
                                <label class="upload_header custom-checkbox">
                                    <input type="checkbox" />
                                    <span class="checkmark"></span>
                                    <span class="checkbox-title">Payment Receipts (Paypal, Upwork, etc...)</span>
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
                            <div class="upload_card">
                                <label class="upload_header custom-checkbox">
                                    <input type="checkbox" />
                                    <span class="checkmark"></span>
                                    <span class="checkbox-title">IT Report</span>
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
                        <button class="btn-submit">Save & Continue</button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Pensioner-->
    <div class="modal fade custom_bussiness_type_modal" id="Pensioner-modal" tabindex="-1"
        aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="exampleModalLabel">Pensioner Business Proof</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="business_box">
                        <div class="business_box_inner">
                            <div class="upload_card active">
                                <label class="upload_header custom-checkbox">
                                    <input type="checkbox" checked />
                                    <span class="checkmark"></span>
                                    <span class="checkbox-title">PPO (Pension Payment Order)</span>
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
                            <div class="upload_card">
                                <label class="upload_header custom-checkbox">
                                    <input type="checkbox" />
                                    <span class="checkmark"></span>
                                    <span class="checkbox-title">Latest Pension Slip</span>
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
                            <div class="upload_card">
                                <label class="upload_header custom-checkbox">
                                    <input type="checkbox" />
                                    <span class="checkmark"></span>
                                    <span class="checkbox-title">Bank Statement</span>
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
                            <div class="upload_card">
                                <label class="upload_header custom-checkbox">
                                    <input type="checkbox" />
                                    <span class="checkmark"></span>
                                    <span class="checkbox-title">Utilities Bill</span>
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
                            <div class="upload_card">
                                <label class="upload_header custom-checkbox">
                                    <input type="checkbox" />
                                    <span class="checkmark"></span>
                                    <span class="checkbox-title">Life Certificate</span>
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
                            <div class="upload_card">
                                <label class="upload_header custom-checkbox">
                                    <input type="checkbox" />
                                    <span class="checkmark"></span>
                                    <span class="checkbox-title">IT Report</span>
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
                        <button class="btn-submit">Save & Continue</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script src="{{ asset('js/business_proof.js') }}"></script>
@endpush
