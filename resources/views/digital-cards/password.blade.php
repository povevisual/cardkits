<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}" dir="{{ app()->getLocale() === 'ar' ? 'rtl' : 'ltr' }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    
    <title>Password Protected - {{ $digitalCard->name }}</title>
    
    <!-- Styles -->
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    
    <style>
        body {
            font-family: 'Inter', sans-serif;
        }
        .gradient-bg {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        }
        .card-shadow {
            box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04);
        }
    </style>
</head>
<body class="bg-gray-50 min-h-screen">
    <div class="min-h-screen gradient-bg flex items-center justify-center p-4">
        <div class="max-w-md w-full">
            <div class="bg-white rounded-2xl card-shadow overflow-hidden">
                <!-- Header -->
                <div class="p-6 text-center border-b border-gray-200">
                    <div class="w-16 h-16 bg-indigo-100 rounded-full flex items-center justify-center mx-auto mb-4">
                        <i class="fas fa-lock text-2xl text-indigo-600"></i>
                    </div>
                    <h1 class="text-xl font-bold text-gray-900 mb-2">Password Protected</h1>
                    <p class="text-gray-600">This digital card is password protected</p>
                </div>
                
                <!-- Card Preview -->
                <div class="p-6 bg-gray-50">
                    <div class="text-center">
                        @if($digitalCard->profile_photo)
                            <img src="{{ $digitalCard->profile_photo_url }}" 
                                 alt="{{ $digitalCard->name }}" 
                                 class="w-16 h-16 rounded-full mx-auto mb-3 object-cover">
                        @else
                            <div class="w-16 h-16 bg-gradient-to-br from-indigo-400 to-purple-500 rounded-full flex items-center justify-center mx-auto mb-3">
                                <span class="text-white text-xl font-bold">{{ substr($digitalCard->name, 0, 1) }}</span>
                            </div>
                        @endif
                        <h2 class="text-lg font-semibold text-gray-900">{{ $digitalCard->name }}</h2>
                        <p class="text-sm text-gray-600">{{ $digitalCard->title }}</p>
                        @if($digitalCard->company)
                            <p class="text-xs text-gray-500">{{ $digitalCard->company }}</p>
                        @endif
                    </div>
                </div>
                
                <!-- Password Form -->
                <div class="p-6">
                    <form action="{{ route('digital-card.verify-password', $digitalCard->slug) }}" method="POST">
                        @csrf
                        
                        <div class="mb-4">
                            <label for="password" class="block text-sm font-medium text-gray-700 mb-2">
                                Enter Password
                            </label>
                            <div class="relative">
                                <input type="password" 
                                       id="password" 
                                       name="password" 
                                       required
                                       class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-colors duration-200"
                                       placeholder="Enter the password">
                                <button type="button" 
                                        onclick="togglePassword()"
                                        class="absolute inset-y-0 right-0 pr-3 flex items-center">
                                    <i id="password-icon" class="fas fa-eye text-gray-400 hover:text-gray-600"></i>
                                </button>
                            </div>
                            @error('password')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                        
                        <button type="submit" 
                                class="w-full bg-indigo-600 text-white font-medium py-3 px-4 rounded-lg hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition-colors duration-200">
                            <i class="fas fa-unlock mr-2"></i>
                            Access Card
                        </button>
                    </form>
                    
                    <div class="mt-4 text-center">
                        <p class="text-xs text-gray-500">
                            Contact the card owner for the password
                        </p>
                    </div>
                </div>
            </div>
            
            <!-- Footer -->
            <div class="mt-6 text-center">
                <p class="text-xs text-white text-opacity-80">
                    Powered by <span class="font-medium">CardKits</span>
                </p>
            </div>
        </div>
    </div>
    
    <script>
        function togglePassword() {
            const passwordInput = document.getElementById('password');
            const passwordIcon = document.getElementById('password-icon');
            
            if (passwordInput.type === 'password') {
                passwordInput.type = 'text';
                passwordIcon.classList.remove('fa-eye');
                passwordIcon.classList.add('fa-eye-slash');
            } else {
                passwordInput.type = 'password';
                passwordIcon.classList.remove('fa-eye-slash');
                passwordIcon.classList.add('fa-eye');
            }
        }
        
        // Focus on password input when page loads
        document.addEventListener('DOMContentLoaded', function() {
            document.getElementById('password').focus();
        });
    </script>
</body>
</html>