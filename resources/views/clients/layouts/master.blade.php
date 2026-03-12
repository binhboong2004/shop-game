<!DOCTYPE html>
<html class="dark" lang="vi">
<head>
    <meta charset="utf-8" />
    <meta content="width=device-width, initial-scale=1.0" name="viewport" />
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'ShopNickVN')</title>
    <script src="https://cdn.tailwindcss.com?plugins=forms,container-queries"></script>
    <link href="https://fonts.googleapis.com/css2?family=Be+Vietnam+Pro:wght@400;500;700;900&amp;display=swap" rel="stylesheet" />
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght@100..700,0..1&amp;display=swap" rel="stylesheet" />
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&amp;display=swap" rel="stylesheet" />
    <link rel="stylesheet" href="{{ asset('assets/clients/css/style.css') }}">
    <script src="{{ asset('assets/clients/js/script.js') }}"></script>
    @stack('styles')
</head>
<body class="bg-background-light dark:bg-background-dark text-slate-900 dark:text-slate-100 min-h-screen">
    <div class="layout-container flex h-full grow flex-col">
        @include('clients.partials.header')
        <main class="flex flex-col flex-1 max-w-[1280px] mx-auto w-full px-4 sm:px-6">
            @yield('content')
        </main>
        @include('clients.partials.footer')
    </div>
    <div id="toast-container" class="fixed top-5 right-5 z-[9999] flex flex-col gap-3"></div>
    @if(session('auth_state_changed'))
    <script>
        localStorage.setItem('auth_sync_event', Date.now());
    </script>
    @endif
    <script>
        window.addEventListener('storage', function(e) {
            if (e.key === 'auth_sync_event') {
                window.location.reload();
            }
        });
    </script>
    @stack('scripts')
</body>
</html>