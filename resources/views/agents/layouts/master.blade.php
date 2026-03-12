<!DOCTYPE html>
<html class="dark" lang="vi">

<head>
    <meta charset="utf-8" />
    <meta content="width=device-width, initial-scale=1.0" name="viewport" />
    <title>@yield('title', 'Đại lý Game - ShopNickVN')</title>
    <script src="https://cdn.tailwindcss.com?plugins=forms,container-queries"></script>
    <script src="{{ asset('assets/agents/js/tailwind-config.js') }}"></script>
    <link href="https://fonts.googleapis.com/css2?family=Be+Vietnam+Pro:wght@400;500;600;700;800;900&display=swap" rel="stylesheet" />
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200&display=swap" rel="stylesheet" />
    <link rel="stylesheet" href="{{ asset('assets/agents/css/style.css') }}">
    @stack('styles')
</head>

<body class="bg-agent-bg text-agent-text font-sans antialiased selection:bg-agent-primary selection:text-white">
    <div class="flex h-screen overflow-hidden">
        @include('agents.partials.sidebar')

        <div class="flex-1 flex flex-col overflow-hidden relative">
            @include('agents.partials.header')
            
            <main class="flex-1 overflow-x-hidden overflow-y-auto bg-agent-bg p-4 sm:p-6 custom-scrollbar">
                @yield('content')
            </main>
        </div>

    </div>
    @stack('scripts')
</body>

</html>