@extends('layouts.app')

@section('styles')
    <link rel="stylesheet" href="{{ asset('css/user_setting.css') }}">
@endsection

@section('content')
 <section class="header-wrapper">
        <div class="container">
            <header class="header-inner">
                <h2 class="logo-text">LoanHub</h2>
                <div class="header-right">
                    <div class="notification">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                            class="bi bi-bell-fill" viewBox="0 0 16 16">
                            <path
                                d="M8 16a2 2 0 0 0 2-2H6a2 2 0 0 0 2 2m.995-14.901a1 1 0 1 0-1.99 0A5 5 0 0 0 3 6c0 1.098-.5 6-2 7h14c-1.5-1-2-5.902-2-7 0-2.42-1.72-4.44-4.005-4.901" />
                        </svg>
                        <span class="dot"></span>
                    </div>
                    <div class="profile-dropdown">
                        <div class="profile-toggle">
                            <img src="https://i.pravatar.cc/40" alt="User">
                            <span class="user-name"></span>
                            <i class="fas fa-caret-down"></i>
                        </div>
                        <div class="profile-menu">
                            <a href="{{ route('user_setting') }}">Setting</a>
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button type="submit">Logout</button>
                            </form>
                        </div>
                    </div>
                </div>
            </header>
        </div>
    </section>
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

                    <div class="header-btn">
                        <button class="sidebar-toggle">
                            <i class="fa-solid fa-bars"></i>
                        </button>
                        <div class="" style="display: flex; gap: 10px;">
                            <button type="button" class="btn-cancel">Cancel</button>
                            <button type="button" class="btn-submit">Save Changes</button>
                        </div>
                    </div>

                    <main class="main">
                        <!-- Profile -->
                        <div class="card setting-section" id="personal-info">
                            <h3>Personal Information</h3>
                            <div class="profile-info">
                                <div class="profile">
                                    <img src="https://i.pravatar.cc/150?img=47" alt="Profile">
                                    <a href="#" id="">Change Photo</a>
                                </div>

                                <div class="form-grid">
                                    <div class="form-group">
                                        <label>First Name</label>
                                        <input type="text" class="form-control" id="" value="Sarah">
                                    </div>
                                    <div class="form-group">
                                        <label>Last Name</label>
                                        <input type="text" class="form-control" id="" value="Johnson">
                                    </div>

                                    <div class="form-group">
                                        <label>Email</label>
                                        <input type="email" class="form-control" id="" value="info@gmail.com">
                                    </div>

                                    <div class="form-group">
                                        <label>Phone</label>
                                        <input type="text" class="form-control" id="" value="+91 1234567890">
                                    </div>

                                    <div class="form-group" style="grid-column: 1 / -1;">
                                        <label>Address</label>
                                        <textarea rows="5" class="form-control" id="">32 ABC Society, Katargam, Surat, Gujarat, India</textarea>
                                    </div>
                                </div>
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
                                    <a href="#">Change</a>
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
@endpush
