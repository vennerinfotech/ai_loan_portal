 <section class="header-wrapper">
        <div class="container">
            <header class="header-inner">
                <h2 class="logo-text">LOGO</h2>
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
                            <img src="{{ Auth::user()->profile_image ? asset('storage/' . Auth::user()->profile_image) : 'https://i.pravatar.cc/40' }}" 
                                 alt="User" 
                                 style="width: 40px; height: 40px; border-radius: 50%; object-fit: cover;">
                            <span class="user-name">{{ Auth::user()->name }}</span>
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
