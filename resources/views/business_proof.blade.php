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

    <section class="section-wrapper">
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
                    <a href="#" class="select-link">
                        Select <span class="arrow">→</span>
                    </a>
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

@push('scripts')
@endpush
