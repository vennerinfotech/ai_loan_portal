@extends('layouts.app')

@section('styles')
    <link rel="stylesheet" href="{{ asset('css/user_setting.css') }}">
    <link rel="stylesheet" href="{{ asset('css/common_header.css') }}">
@endsection

@section('content')
@include('layouts.common_header')
    <section class="user-setting-wrapper">
        <div class="container">
            <div class="user-setting-inner">
                <aside class="sidebar">
                    <div class="setting-icon">
                        <i class="fa-solid fa-gear"></i>
                        <h2>Setting</h2>
                    </div>
                    <ul>
                        <li class="active"><i class="fa-solid fa-user pr-2"></i><a href="#"
                                data-target="personal-info">Personal Info</a></li>
                        <li><i class="fa-solid fa-key pr-2"></i><a href="#" data-target="security">Security</a></li>
                        <li><i class="fa-solid fa-bell pr-2"></i><a href="#"
                                data-target="notification">Notifications</a></li>
                        <li><i class="fa-solid fa-circle-question pr-2"></i><a href="#" data-target="help">Help &
                                Support</a></li>
                        <li class="logout"><i class="fa-solid fa-sign-out pr-2"></i><a
                                href="{{ route('logout') }}">Logout</a></li>
                    </ul>
                </aside>
                <div class="main-right">
                    @if(session('success'))
                        <script>
                            document.addEventListener("DOMContentLoaded", function() {
                                Swal.fire({
                                    icon: 'success',
                                    title: 'Success',
                                    text: "{{ session('success') }}",
                                    confirmButtonColor: '#252484', // Primary color
                                    confirmButtonText: 'OK',
                                    customClass: {
                                        popup: 'animated fadeIn', // Optional animation
                                        title: 'swal2-title',     // Ensuring it uses our customized title class if defined
                                        content: 'swal2-content'
                                    },
                                    background: '#fff',
                                    color: '#333' // Text color
                                });
                            });
                        </script>
                    @endif
                    @if($errors->any())
                        <script>
                            document.addEventListener("DOMContentLoaded", function() {
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Error',
                                    html: '{!! implode("<br>", $errors->all()) !!}',
                                    confirmButtonColor: '#d33',
                                });
                            });
                        </script>
                    @endif

                    <div class="header-btn">
                        <button class="sidebar-toggle">
                            <i class="fa-solid fa-bars"></i>
                        </button>
                        <div class="" style="display: flex; gap: 10px;">
                            <button type="button" class="btn-cancel" onclick="window.location.href='{{ route('dashboard') }}'">Cancel</button>
                            <button type="button" class="btn-submit" onclick="document.getElementById('personal-info-form').submit()">Save Changes</button>
                        </div>
                    </div>

                    <main class="main">
                        <!-- Profile -->
                        <div class="card setting-section" id="personal-info">
                            <h3>Personal Information</h3>
                            <div class="profile-info">
                                <form id="personal-info-form" action="{{ route('update.personal.info') }}" method="POST" enctype="multipart/form-data" class="profile-info" style="width: 100%;">
                                    @csrf
                                    
                                    <!-- Left Column: Profile Image -->
                                    <div class="profile">
                                        <div class="profile-image-container" style="position: relative; display: inline-block;">
                                            <img id="profile-preview" 
                                                 src="{{ $user->profile_image ? asset('storage/' . $user->profile_image) : asset('images/user-profile.jpg') }}" 
                                                 alt="Profile" 
                                                 style="width: 80px; height: 80px; border-radius: 50%; object-fit: cover;">
                                            
                                            <label for="profile_image" style="cursor: pointer; display: block; margin-top: 10px; color: #6765e8; text-decoration: none; text-align: center;">
                                                Change Photo
                                            </label>
                                            <input type="file" name="profile_image" id="profile_image" style="display: none;" accept="image/*" onchange="previewImage(this)">
                                        </div>
                                    </div>

                                    <!-- Right Column: Form Fields -->
                                    <div class="form-grid">
                                        <div class="form-group">
                                            <label>First Name</label>
                                            <input type="text" class="form-control" name="first_name" value="{{ $firstName }}">
                                        </div>
                                        <div class="form-group">
                                            <label>Last Name</label>
                                            <input type="text" class="form-control" name="last_name" value="{{ $lastName }}">
                                        </div>

                                        <div class="form-group">
                                            <label>Email</label>
                                            <input type="email" class="form-control" name="email" value="{{ $user->email }}" readonly style="background-color: #e9ecef;">
                                        </div>

                                        <div class="form-group">
                                            <label>Phone</label>
                                            <input type="text" class="form-control" name="phone" value="{{ $user->phone }}" readonly style="background-color: #e9ecef;">
                                        </div>

                                        <div class="form-group" style="grid-column: 1 / -1;">
                                            <label>Address</label>
                                            <textarea rows="5" class="form-control" name="address" readonly style="background-color: #e9ecef;">{{ $user->address }}</textarea>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>

                        <!-- Security -->
                        <div class="card setting-section" id="security">
                            <div class="profile-security">
                                <h3>Security Settings</h3>
                                <div class="securify-pin mb-4">
                                    <div>
                                        <h4>Change MPIN</h4>
                                        <span>Update your mobile PIN for enhanced security</span>
                                    </div>
                                    <a href="{{ route('change.mpin') }}">Change</a>
                                </div>
                                <div class="securify-pin">
                                    <div>
                                        <h4>Forgot MPIN</h4>
                                        <span>Reset your MPIN if you've forgotten it</span>
                                    </div>
                                    <a href="{{ route('forgot_mpin') }}" target="_blank">Reset</a>
                                </div>
                            </div>
                        </div>

                        <!-- Notification -->
                        <div class="card setting-section" id="notification">
                            <h3>App Preferences</h3>
                            <div class="form-grid">
                                <div class="form-group">
                                    <label>Language</label>
                                    <input type="text" class="form-control" placeholder="English" id=""
                                        readonly>
                                </div>
                                <div class="form-group">
                                    <label>Time Zone</label>
                                    <input type="text" class="form-control" placeholder="Kolkata, India" id=""
                                        readonly>
                                </div>
                            </div>
                            <div class="notification-info mt-4">
                                <div>
                                    <h4>Push Notifications</h4>
                                    <span>Receive notifications about important updates</span>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" value="" id="checkChecked"
                                        checked>
                                </div>
                            </div>
                        </div>

                        <!-- Help -->
                        <div class="card setting-section" id="help">
                            <h3>Help & Support</h3>
                            <div class="help-box">
                                <div class="inner-box">
                                    <i class="fa-solid fa-envelope"></i>
                                    <h4>Email Address</h4>
                                    <a href="#">info@gmail.com</a>
                                </div>
                                <div class="inner-box">
                                    <i class="fa-brands fa-whatsapp"></i>
                                    <h4>WhatsApp Chat</h4>
                                    <a href="#">+91 1234567890</a>
                                </div>
                                <div class="inner-box">
                                    <i class="fa-solid fa-phone"></i>
                                    <h4>Contact Us</h4>
                                    <a href="#">+91 1234567890</a>
                                </div>
                            </div>
                        </div>
                    </main>
                </div>
            </div>
        </div>
    </section>
@endsection
@push('scripts')
    <script src="{{ asset('js/user-setting.js') }}"></script>
    <script>
        function previewImage(input) {
            if (input.files && input.files[0]) {
                var reader = new FileReader();
                
                reader.onload = function(e) {
                    document.getElementById('profile-preview').src = e.target.result;
                }
                
                reader.readAsDataURL(input.files[0]);
            }
        }
    </script>
@endpush
