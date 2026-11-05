<nav id="navbar" class="w-full transition-all duration-300 ease-in-out">
    <div class="flex items-center justify-between mx-auto px-6 py-4">

        <!-- Logo -->
        <a href="{{ url('/') }}" class="flex items-center gap-2.5 flex-shrink-0">
            <img src="{{ asset('/img/logo.png') }}" class="h-10" alt="Virgo Logo" />
            <span class="text-2xl font-semibold text-white">Virgo</span>
        </a>

        <!-- Desktop Center Nav -->
        <div class="hidden lg:flex items-center gap-1">
            <a href="{{ url('/category') }}"
               class="text-content-secondary hover:text-white hover:bg-white/10 px-4 py-2 rounded-xl transition text-sm font-medium">
                Category
            </a>
            <a href="{{ url('/show/watched') }}"
               class="text-content-secondary hover:text-white hover:bg-white/10 px-4 py-2 rounded-xl transition text-sm font-medium">
                Top Movies
            </a>
            <a href="{{ url('/show/free') }}"
               class="text-content-secondary hover:text-white hover:bg-white/10 px-4 py-2 rounded-xl transition text-sm font-medium">
                Free Movies
            </a>
        </div>

        <!-- Desktop Right: Search + Auth -->
        <div class="hidden lg:flex items-center gap-3">

            <!-- Search -->
            <form action="{{ url('/search') }}" class="relative">
                <svg class="absolute left-3 top-1/2 -translate-y-1/2 w-4 h-4 text-content-muted pointer-events-none" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-4.35-4.35M17 11A6 6 0 1 1 5 11a6 6 0 0 1 12 0z"/>
                </svg>
                <input type="text" name="search" placeholder="Search..."
                       class="bg-white/10 text-white text-sm pl-9 pr-4 py-2 rounded-xl outline-none placeholder-content-muted focus:bg-white/15 focus:ring-1 focus:ring-white/20 transition w-40">
            </form>

            @auth
                <!-- Initials Avatar + Dropdown -->
                <div class="relative">
                    <button id="user-menu-button" type="button" aria-expanded="false"
                            class="w-9 h-9 rounded-full bg-brand hover:bg-brand-dark flex items-center justify-center text-white font-bold text-sm uppercase transition focus:outline-none select-none">
                        {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                    </button>

                    <div id="user-dropdown"
                         class="hidden absolute right-0 top-12 z-50 w-52 bg-surface-card border border-surface-border rounded-2xl shadow-2xl overflow-hidden">
                        <div class="px-4 py-3 border-b border-surface-border">
                            <p class="text-content-primary text-sm font-medium truncate">{{ auth()->user()->name }}</p>
                            <p class="text-content-muted text-xs truncate">{{ auth()->user()->email }}</p>
                        </div>
                        <div class="py-1.5">
                            <a href="{{ url('/dashboard') }}"
                               class="flex items-center gap-3 px-4 py-2.5 text-content-secondary hover:text-white hover:bg-surface-raised text-sm transition">
                                <svg class="w-4 h-4 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zm10 0a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zm10 0a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z"/>
                                </svg>
                                Dashboard
                            </a>
                            <form action="{{ url('/logout') }}" method="post">
                                @csrf
                                <button type="submit"
                                        class="flex items-center gap-3 w-full px-4 py-2.5 text-red-400 hover:text-red-300 hover:bg-surface-raised text-sm transition">
                                    <svg class="w-4 h-4 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/>
                                    </svg>
                                    Sign out
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            @else
                <a href="{{ url('/login') }}"
                   class="text-content-secondary hover:text-white text-sm font-medium transition px-3 py-2 rounded-xl hover:bg-white/10">
                    Login
                </a>
                <a href="{{ url('/register') }}"
                   class="bg-brand hover:bg-brand-dark text-white text-sm font-medium px-4 py-2 rounded-xl transition">
                    Sign up
                </a>
            @endauth
        </div>

        <!-- Mobile Hamburger -->
        <button id="hamburger-btn" type="button" class="lg:hidden flex flex-col justify-center items-center w-9 h-9" aria-label="Toggle menu">
            <span id="ham-line-1" class="block w-6 h-0.5 bg-white rounded transition-all duration-300"></span>
            <span id="ham-line-2" class="block w-6 h-0.5 bg-white rounded my-1 transition-all duration-300"></span>
            <span id="ham-line-3" class="block w-6 h-0.5 bg-white rounded transition-all duration-300"></span>
        </button>

    </div>
</nav>

<!-- Mobile Overlay -->
<div id="menu-overlay" class="lg:hidden fixed inset-0 bg-black/60 backdrop-blur-sm z-40 opacity-0 pointer-events-none transition-opacity duration-300"></div>

<!-- Mobile Side Drawer -->
<div id="side-drawer" class="lg:hidden fixed top-0 right-0 h-full w-72 bg-surface-card z-50 translate-x-full transition-transform duration-300 ease-in-out shadow-2xl flex flex-col border-l border-surface-border">

    <!-- Drawer Header -->
    <div class="flex items-center justify-between px-6 py-5 border-b border-surface-border">
        <span class="text-content-primary font-semibold tracking-widest uppercase text-xs">Menu</span>
        <button id="close-drawer-btn" type="button" class="text-content-muted hover:text-white transition p-1 rounded-lg hover:bg-surface-raised">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
            </svg>
        </button>
    </div>

    <!-- Drawer Body -->
    <div class="flex flex-col flex-1 overflow-y-auto px-4 py-5 gap-5">
        <!-- Search -->
            <form action="{{ url('/search') }}" class="flex items-center gap-2 bg-surface-raised border border-surface-border focus-within:border-brand focus-within:ring-1 focus-within:ring-brand rounded-xl px-4 py-2.5 transition-colors">
                <svg class="w-4 h-4 text-content-muted flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-4.35-4.35M17 11A6 6 0 1 1 5 11a6 6 0 0 1 12 0z"/>
                </svg>
                <input type="text" name="search" placeholder="Search movies..."
                    class="bg-transparent text-content-primary text-sm flex-1 outline-none placeholder-content-muted">
            </form>

        @auth
        <!-- User Info -->
        <div class="flex items-center gap-3 bg-surface-raised border border-surface-border rounded-xl px-4 py-3">
            <div class="w-10 h-10 rounded-full bg-brand flex items-center justify-center text-white font-bold text-sm flex-shrink-0 uppercase select-none">
                {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
            </div>
            <div class="min-w-0">
                <p class="text-content-primary font-medium text-sm truncate">{{ auth()->user()->name }}</p>
                <p class="text-content-muted text-xs truncate">{{ auth()->user()->email }}</p>
            </div>
        </div>
        @endauth

        <!-- Nav Links -->
        <nav class="flex flex-col gap-1">
            <a href="{{ url('/') }}"
               class="flex items-center gap-3 text-content-secondary hover:text-white hover:bg-surface-raised rounded-xl px-4 py-3 transition text-sm font-medium">
                <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/>
                </svg>
                Home
            </a>
            <a href="{{ url('/category') }}"
               class="flex items-center gap-3 text-content-secondary hover:text-white hover:bg-surface-raised rounded-xl px-4 py-3 transition text-sm font-medium">
                <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h7"/>
                </svg>
                Category
            </a>
            <a href="{{ url('/show/watched') }}"
               class="flex items-center gap-3 text-content-secondary hover:text-white hover:bg-surface-raised rounded-xl px-4 py-3 transition text-sm font-medium">
                <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"/>
                </svg>
                Top Movies
            </a>
            <a href="{{ url('/show/free') }}"
               class="flex items-center gap-3 text-content-secondary hover:text-white hover:bg-surface-raised rounded-xl px-4 py-3 transition text-sm font-medium">
                <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 3l14 9-14 9V3z"/>
                </svg>
                Free Movies
            </a>
            @auth
            <a href="{{ url('/dashboard') }}"
               class="flex items-center gap-3 text-content-secondary hover:text-white hover:bg-surface-raised rounded-xl px-4 py-3 transition text-sm font-medium">
                <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zm10 0a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zm10 0a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z"/>
                </svg>
                Dashboard
            </a>
            @endauth
        </nav>
    </div>

    <!-- Drawer Footer -->
    <div class="px-4 pb-6 border-t border-surface-border pt-4">
        @auth
        <form action="{{ url('/logout') }}" method="post">
            @csrf
            <button type="submit"
                    class="flex items-center gap-3 text-red-400 hover:text-red-300 hover:bg-surface-raised rounded-xl px-4 py-3 w-full transition text-sm font-medium">
                <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/>
                </svg>
                Sign Out
            </button>
        </form>
        @else
        <a href="{{ url('/login') }}"
           class="flex items-center gap-3 text-content-secondary hover:text-white hover:bg-surface-raised rounded-xl px-4 py-3 transition text-sm font-medium">
            <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1"/>
            </svg>
            Login
        </a>
        @endauth
    </div>
</div>
