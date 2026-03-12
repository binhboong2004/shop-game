<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Admin Dashboard') - ShopNickVN</title>
    
    <!-- Fonts & Icons -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" />
    <script src="https://cdn.tailwindcss.com"></script>
    
    <!-- Config tailwind -->
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: { sans: ['Inter', 'sans-serif'] },
                    colors: {
                        admin: {
                            bg: '#13131A',
                            sidebar: '#1a1c23',
                            card: '#20222a',
                            border: '#2a2d35',
                            primary: '#E70814',
                            hover: '#ff0f1e',
                            muted: '#8b8d93'
                        }
                    }
                }
            }
        }
    </script>
    
    <!-- Base CSS -->
    <style>
        .material-symbols-outlined {
            font-variation-settings: 'FILL' 1, 'wght' 400, 'GRAD' 0, 'opsz' 24;
        }
    </style>
    <link rel="stylesheet" href="{{ asset('assets/admin/css/admin.css') }}">
    @stack('styles')
</head>
<body class="bg-admin-bg text-white font-sans overflow-x-hidden min-h-screen flex text-sm">

    <!-- Sidebar Partial -->
    @include('admin.partials.sidebar')

    <!-- Main Content Wrapper -->
    <div class="flex-1 flex flex-col min-w-0">
        <!-- Top Header Partial -->
        @include('admin.partials.header')

        <!-- Page Content -->
        <main class="flex-1 p-4 md:p-6 lg:p-8 overflow-y-auto admin-scrollbar">
            @yield('content')
        </main>
    </div>

    <!-- Mobile Overlay -->
    <div id="admin-overlay" class="admin-overlay fixed inset-0 bg-black/50 backdrop-blur-sm z-40 hidden lg:hidden"></div>

    <script src="{{ asset('assets/admin/js/admin.js') }}"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            @if(session('success'))
                showToast("{{ session('success') }}", 'success');
            @endif

            @if(session('error'))
                showToast("{{ session('error') }}", 'error');
            @endif
            
            @if($errors->any())
                @foreach($errors->all() as $error)
                    showToast("{{ $error }}", 'error');
                @endforeach
            @endif
        });
    </script>
    @stack('scripts')
</body>
</html>
