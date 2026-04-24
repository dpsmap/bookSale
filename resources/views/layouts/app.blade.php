<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Book Sale Platform')</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js" defer></script>
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/dataTables.tailwindcss.min.css">
    <script src="https://code.jquery.com/jquery-3.7.0.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
</head>
<body class="bg-gray-50">
    <nav class="bg-white shadow-sm border-b sticky top-0 z-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-16">
                <div class="flex items-center">
                    <a href="{{ route('home') }}" class="text-xl font-bold text-gray-900">
                        {{-- Book Sale Platform --}}
                        <img src="{{ asset('images/dpslogo.svg') }}" alt="Book Sale Platform" class="h-10">
                    </a>
                </div>
                <div class="flex items-center space-x-4">
                    <a href="{{ route('home') }}" class="text-gray-600 hover:text-gray-900">Home</a>
                    <a href="{{ route('order.create') }}" class="text-gray-600 hover:text-gray-900">Order Book</a>
                    <a href="{{ route('order.check') }}" class="text-gray-600 hover:text-gray-900">Check Order</a>
                    <a href="{{ route('admin.login') }}" class="text-gray-600 hover:text-gray-900">Admin</a>
                </div>
            </div>
        </div>
    </nav>

    <main class="py-6">
        @yield('content')
    </main>

    <footer class="bg-white border-t mt-auto">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-4">
            <p class="text-center text-gray-500 text-sm">
                © 2026 Book Sale Platform. All rights reserved.
            </p>
        </div>
    </footer>

    @if(session('error'))
        <div x-data="{ show: true }" x-show="show" x-transition class="fixed bottom-4 right-4 bg-red-500 text-white px-6 py-3 rounded-lg shadow-lg">
            <span>{{ session('error') }}</span>
            <button @click="show = false" class="ml-4 text-white hover:text-gray-200">×</button>
        </div>
    @endif

    @if(session('success'))
        <div x-data="{ show: true }" x-show="show" x-transition class="fixed bottom-4 right-4 bg-green-500 text-white px-6 py-3 rounded-lg shadow-lg">
            <span>{{ session('success') }}</span>
            <button @click="show = false" class="ml-4 text-white hover:text-gray-200">×</button>
        </div>
    @endif
</body>
</html>
