<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'Laravel') }}</title>
    <link rel="icon" href="{{ asset('/img/logo.png') }}">
  @vite(['resources/css/app.css','resources/js/app.js'])
  @include('components.font')
</head>
<body class="bg-surface">
    <div class="fixed top-0 left-0 right-0 z-30">
        @include('components.navbar')
    </div>
   @yield('container')


   <script>
        document.addEventListener("DOMContentLoaded", function () {

            // --- Mobile hamburger drawer ---
            const hamburgerBtn = document.getElementById('hamburger-btn');
            const closeDrawerBtn = document.getElementById('close-drawer-btn');
            const sideDrawer = document.getElementById('side-drawer');
            const overlay = document.getElementById('menu-overlay');

            function openDrawer() {
                sideDrawer.classList.remove('translate-x-full');
                overlay.classList.remove('opacity-0', 'pointer-events-none');
                overlay.classList.add('opacity-100');
                document.body.style.overflow = 'hidden';
            }

            function closeDrawer() {
                sideDrawer.classList.add('translate-x-full');
                overlay.classList.add('opacity-0', 'pointer-events-none');
                overlay.classList.remove('opacity-100');
                document.body.style.overflow = '';
            }

            if (hamburgerBtn) {
                hamburgerBtn.addEventListener('click', function () {
                    sideDrawer.classList.contains('translate-x-full') ? openDrawer() : closeDrawer();
                });
            }
            if (closeDrawerBtn) closeDrawerBtn.addEventListener('click', closeDrawer);
            if (overlay) overlay.addEventListener('click', closeDrawer);
            document.addEventListener('keydown', function (e) {
                if (e.key === 'Escape') closeDrawer();
            });

            // --- Desktop user dropdown ---
            const userMenuButton = document.getElementById('user-menu-button');
            const userDropdown = document.getElementById('user-dropdown');
            if (userMenuButton && userDropdown) {
                userMenuButton.addEventListener('click', function (e) {
                    userDropdown.classList.toggle('hidden');
                    e.stopPropagation();
                });
                document.addEventListener('click', function (e) {
                    if (!userDropdown.contains(e.target) && !userMenuButton.contains(e.target)) {
                        userDropdown.classList.add('hidden');
                    }
                });
            }
        });

        // Navbar background on scroll
        const navbar = document.getElementById('navbar');
        window.addEventListener('scroll', function () {
            if (window.scrollY > 80) {
                navbar.classList.add('bg-surface/95', 'backdrop-blur-md', 'border-b', 'border-surface-border');
            } else {
                navbar.classList.remove('bg-surface/95', 'backdrop-blur-md', 'border-b', 'border-surface-border');
            }
        });
   </script>

</body>
</html>
