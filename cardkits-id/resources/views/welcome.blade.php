<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ config('app.name', 'Laravel') }}</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</head>
<body class="antialiased">
    <div class="relative sm:flex sm:justify-center sm:items-center min-h-screen bg-gradient-to-br from-blue-600 via-purple-600 to-pink-600">
        <div class="max-w-7xl mx-auto p-6 lg:p-8">
            <div class="flex justify-center">
                <div class="text-center">
                    <h1 class="text-6xl font-bold text-white mb-8">
                        <i class="fas fa-link mr-4"></i>
                        {{ config('app.name', 'Laravel') }}
                    </h1>
                    <p class="text-xl text-white opacity-90 mb-12 max-w-2xl">
                        Create beautiful bio link pages like Linktree. Share all your important links in one place with a stunning, customizable design.
                    </p>
                    
                    <div class="flex flex-col sm:flex-row gap-4 justify-center">
                        @auth
                            <a href="{{ route('bio-links.index') }}" 
                               class="bg-white text-blue-600 px-8 py-4 rounded-lg text-lg font-semibold hover:bg-gray-100 transition-colors">
                                <i class="fas fa-link mr-2"></i>My Bio Links
                            </a>
                        @else
                            <a href="{{ route('login') }}" 
                               class="bg-white text-blue-600 px-8 py-4 rounded-lg text-lg font-semibold hover:bg-gray-100 transition-colors">
                                <i class="fas fa-sign-in-alt mr-2"></i>Sign In
                            </a>
                            <a href="{{ route('register') }}" 
                               class="bg-transparent border-2 border-white text-white px-8 py-4 rounded-lg text-lg font-semibold hover:bg-white hover:text-blue-600 transition-colors">
                                <i class="fas fa-user-plus mr-2"></i>Get Started
                            </a>
                        @endauth
                    </div>
                </div>
            </div>
            
            <!-- Features -->
            <div class="mt-20 grid grid-cols-1 md:grid-cols-3 gap-8">
                <div class="text-center">
                    <div class="bg-white bg-opacity-20 rounded-full w-16 h-16 flex items-center justify-center mx-auto mb-4">
                        <i class="fas fa-palette text-white text-2xl"></i>
                    </div>
                    <h3 class="text-white text-xl font-semibold mb-2">Customizable Design</h3>
                    <p class="text-white opacity-80">Choose colors, fonts, and layouts to match your brand</p>
                </div>
                
                <div class="text-center">
                    <div class="bg-white bg-opacity-20 rounded-full w-16 h-16 flex items-center justify-center mx-auto mb-4">
                        <i class="fas fa-chart-line text-white text-2xl"></i>
                    </div>
                    <h3 class="text-white text-xl font-semibold mb-2">Analytics</h3>
                    <p class="text-white opacity-80">Track views, clicks, and engagement with detailed analytics</p>
                </div>
                
                <div class="text-center">
                    <div class="bg-white bg-opacity-20 rounded-full w-16 h-16 flex items-center justify-center mx-auto mb-4">
                        <i class="fas fa-mobile-alt text-white text-2xl"></i>
                    </div>
                    <h3 class="text-white text-xl font-semibold mb-2">Mobile First</h3>
                    <p class="text-white opacity-80">Optimized for all devices with responsive design</p>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
