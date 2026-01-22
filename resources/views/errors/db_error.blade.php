@extends('layouts.app')

@section('content')
<div class="container d-flex align-items-center justify-content-center" style="min-height: 80vh;">
    <div class="text-center">
        <div class="mb-4">
            <i class="fas fa-exclamation-triangle text-warning fa-4x"></i>
        </div>
        <h2 class="fw-bold mb-3">Something Went Wrong</h2>
        <p class="text-muted mb-4 lead">
            We encountered a temporary issue while processing your request. <br>
            Please try again later or contact support if the problem persists.
        </p>
        <a href="{{ url('/') }}" class="btn btn-primary px-4 py-2">
            Return Home
        </a>
    </div>
</div>
@endsection
