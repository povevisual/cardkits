<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>

    <!-- Custom Styles -->
    <style>
        [x-cloak] { display: none !important; }
    </style>
</head>
<body class="font-sans antialiased bg-gray-50">
    <div class="min-h-screen">
        <!-- Navigation -->
        <nav class="bg-white shadow-sm border-b border-gray-200">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="flex justify-between h-16">
                    <div class="flex">
                        <!-- Logo -->
                        <div class="flex-shrink-0 flex items-center">
                            <a href="{{ route('bio-links.index') }}" class="text-xl font-bold text-blue-600">
                                {{ config('app.name', 'Laravel') }}
                            </a>
                        </div>

                        <!-- Navigation Links -->
                        <div class="hidden sm:ml-6 sm:flex sm:space-x-8">
                            <a href="{{ route('bio-links.index') }}" 
                               class="border-transparent text-gray-500 hover:border-gray-300 hover:text-gray-700 inline-flex items-center px-1 pt-1 border-b-2 text-sm font-medium">
                                <i class="fas fa-link mr-2"></i>Bio Links
                            </a>
                            <a href="#" 
                               class="border-transparent text-gray-500 hover:border-gray-300 hover:text-gray-700 inline-flex items-center px-1 pt-1 border-b-2 text-sm font-medium">
                                <i class="fas fa-chart-bar mr-2"></i>Analytics
                            </a>
                            <a href="#" 
                               class="border-transparent text-gray-500 hover:border-gray-300 hover:text-gray-700 inline-flex items-center px-1 pt-1 border-b-2 text-sm font-medium">
                                <i class="fas fa-cog mr-2"></i>Settings
                            </a>
                        </div>
                    </div>

                    <!-- Right side -->
                    <div class="hidden sm:ml-6 sm:flex sm:items-center">
                        @auth
                            <!-- Profile dropdown -->
                            <div class="ml-3 relative">
                                <div class="flex items-center space-x-4">
                                    <span class="text-gray-700">{{ Auth::user()->name }}</span>
                                    <form method="POST" action="{{ route('logout') }}" class="inline">
                                        @csrf
                                        <button type="submit" class="text-gray-500 hover:text-gray-700 text-sm">
                                            <i class="fas fa-sign-out-alt mr-1"></i>Logout
                                        </button>
                                    </form>
                                </div>
                            </div>
                        @else
                            <a href="{{ route('login') }}" class="text-gray-500 hover:text-gray-700 text-sm">
                                <i class="fas fa-sign-in-alt mr-1"></i>Login
                            </a>
                        @endauth
                    </div>

                    <!-- Mobile menu button -->
                    <div class="-mr-2 flex items-center sm:hidden">
                        <button type="button" class="inline-flex items-center justify-center p-2 rounded-md text-gray-400 hover:text-gray-500 hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-blue-500">
                            <span class="sr-only">Open main menu</span>
                            <i class="fas fa-bars"></i>
                        </button>
                    </div>
                </div>
            </div>

            <!-- Mobile menu -->
            <div class="sm:hidden hidden" id="mobile-menu">
                <div class="pt-2 pb-3 space-y-1">
                    <a href="{{ route('bio-links.index') }}" class="bg-blue-50 border-blue-500 text-blue-700 block pl-3 pr-4 py-2 border-l-4 text-base font-medium">
                        <i class="fas fa-link mr-2"></i>Bio Links
                    </a>
                    <a href="#" class="border-transparent text-gray-500 hover:bg-gray-50 hover:border-gray-300 hover:text-gray-700 block pl-3 pr-4 py-2 border-l-4 text-base font-medium">
                        <i class="fas fa-chart-bar mr-2"></i>Analytics
                    </a>
                    <a href="#" class="border-transparent text-gray-500 hover:bg-gray-50 hover:border-gray-300 hover:text-gray-700 block pl-3 pr-4 py-2 border-l-4 text-base font-medium">
                        <i class="fas fa-cog mr-2"></i>Settings
                    </a>
                </div>
                @auth
                    <div class="pt-4 pb-3 border-t border-gray-200">
                        <div class="px-4">
                            <div class="text-base font-medium text-gray-800">{{ Auth::user()->name }}</div>
                            <div class="text-sm font-medium text-gray-500">{{ Auth::user()->email }}</div>
                        </div>
                        <div class="mt-3 space-y-1">
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button type="submit" class="block w-full text-left px-4 py-2 text-base font-medium text-gray-500 hover:text-gray-800 hover:bg-gray-100">
                                    <i class="fas fa-sign-out-alt mr-1"></i>Logout
                                </button>
                            </form>
                        </div>
                    </div>
                @endauth
            </div>
        </nav>

        <!-- Page Content -->
        <main>
            @yield('content')
        </main>
    </div>

    <!-- Scripts -->
    <script>
        // Mobile menu toggle
        document.addEventListener('DOMContentLoaded', function() {
            const mobileMenuButton = document.querySelector('button[type="button"]');
            const mobileMenu = document.getElementById('mobile-menu');
            
            if (mobileMenuButton && mobileMenu) {
                mobileMenuButton.addEventListener('click', function() {
                    mobileMenu.classList.toggle('hidden');
                });
            }
        });
    </script>
</body>
</html>