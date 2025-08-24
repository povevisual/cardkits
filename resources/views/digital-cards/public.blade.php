<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}" dir="{{ app()->getLocale() === 'ar' ? 'rtl' : 'ltr' }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    
    <!-- SEO Meta Tags -->
    <title>{{ $digitalCard->name }} - {{ $digitalCard->title }}</title>
    <meta name="description" content="{{ $digitalCard->bio ?? $digitalCard->title }}">
    <meta name="keywords" content="{{ $digitalCard->name }}, {{ $digitalCard->title }}, {{ $digitalCard->company }}, digital business card">
    
    <!-- Open Graph Meta Tags -->
    <meta property="og:title" content="{{ $digitalCard->name }} - {{ $digitalCard->title }}">
    <meta property="og:description" content="{{ $digitalCard->bio ?? $digitalCard->title }}">
    <meta property="og:type" content="profile">
    <meta property="og:url" content="{{ $digitalCard->public_url }}">
    @if($digitalCard->profile_photo)
        <meta property="og:image" content="{{ $digitalCard->profile_photo_url }}">
    @endif
    
    <!-- Twitter Card Meta Tags -->
    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:title" content="{{ $digitalCard->name }} - {{ $digitalCard->title }}">
    <meta name="twitter:description" content="{{ $digitalCard->bio ?? $digitalCard->title }}">
    @if($digitalCard->profile_photo)
        <meta name="twitter:image" content="{{ $digitalCard->profile_photo_url }}">
    @endif
    
    <!-- Structured Data -->
    <script type="application/ld+json">
    {
        "@context": "https://schema.org",
        "@type": "Person",
        "name": "{{ $digitalCard->name }}",
        "jobTitle": "{{ $digitalCard->title }}",
        "worksFor": {
            "@type": "Organization",
            "name": "{{ $digitalCard->company }}"
        },
        "email": "{{ $digitalCard->email }}",
        "telephone": "{{ $digitalCard->phone }}",
        "url": "{{ $digitalCard->website }}",
        "address": {
            "@type": "PostalAddress",
            "streetAddress": "{{ $digitalCard->address_line_1 }}",
            "addressLocality": "{{ $digitalCard->city }}",
            "addressRegion": "{{ $digitalCard->state }}",
            "postalCode": "{{ $digitalCard->postal_code }}",
            "addressCountry": "{{ $digitalCard->country }}"
        }
    }
    </script>
    
    <!-- Favicon -->
    <link rel="icon" type="image/x-icon" href="{{ asset('favicon.ico') }}">
    
    <!-- PWA Meta Tags -->
    <meta name="theme-color" content="#4F46E5">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-status-bar-style" content="default">
    <meta name="apple-mobile-web-app-title" content="{{ $digitalCard->name }}">
    
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
        .component-hover {
            transition: all 0.3s ease;
        }
        .component-hover:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 25px -5px rgba(0, 0, 0, 0.1);
        }
        .social-icon {
            transition: all 0.3s ease;
        }
        .social-icon:hover {
            transform: scale(1.1);
        }
        @media (max-width: 640px) {
            .mobile-container {
                padding: 1rem;
            }
        }
    </style>
</head>
<body class="bg-gray-50 min-h-screen">
    <!-- Main Container -->
    <div class="min-h-screen gradient-bg">
        <div class="container mx-auto px-4 py-8">
            <!-- Digital Card -->
            <div class="max-w-md mx-auto">
                <div class="bg-white rounded-2xl card-shadow overflow-hidden">
                    <!-- Cover Photo -->
                    @if($digitalCard->cover_photo)
                        <div class="h-32 bg-cover bg-center" style="background-image: url('{{ $digitalCard->cover_photo_url }}')"></div>
                    @endif
                    
                    <!-- Profile Section -->
                    <div class="p-6 text-center">
                        <!-- Profile Photo -->
                        <div class="relative -mt-16 mb-4">
                            @if($digitalCard->profile_photo)
                                <img src="{{ $digitalCard->profile_photo_url }}" 
                                     alt="{{ $digitalCard->name }}" 
                                     class="w-24 h-24 rounded-full border-4 border-white mx-auto object-cover shadow-lg">
                            @else
                                <div class="w-24 h-24 rounded-full border-4 border-white mx-auto bg-gradient-to-br from-indigo-400 to-purple-500 flex items-center justify-center shadow-lg">
                                    <span class="text-white text-2xl font-bold">{{ substr($digitalCard->name, 0, 1) }}</span>
                                </div>
                            @endif
                        </div>
                        
                        <!-- Name and Title -->
                        <h1 class="text-2xl font-bold text-gray-900 mb-2">{{ $digitalCard->name }}</h1>
                        <p class="text-lg text-gray-600 mb-1">{{ $digitalCard->title }}</p>
                        @if($digitalCard->company)
                            <p class="text-sm text-gray-500 mb-4">{{ $digitalCard->company }}</p>
                        @endif
                        
                        <!-- Bio -->
                        @if($digitalCard->bio)
                            <p class="text-gray-700 text-sm leading-relaxed mb-6">{{ $digitalCard->bio }}</p>
                        @endif
                        
                        <!-- Company Logo -->
                        @if($digitalCard->logo)
                            <div class="mb-6">
                                <img src="{{ $digitalCard->logo_url }}" 
                                     alt="{{ $digitalCard->company }} logo" 
                                     class="h-12 mx-auto object-contain">
                            </div>
                        @endif
                    </div>
                    
                    <!-- Components Section -->
                    @if($digitalCard->components->count() > 0)
                        <div class="px-6 pb-6">
                            <div class="space-y-3">
                                @foreach($digitalCard->components as $component)
                                    @if($component->is_active)
                                        <div class="component-hover">
                                            @switch($component->type)
                                                @case('link')
                                                    <a href="{{ route('digital-card.click', ['slug' => $digitalCard->slug, 'componentId' => $component->id]) }}" 
                                                       class="block w-full p-4 bg-gray-50 hover:bg-indigo-50 rounded-xl border border-gray-200 hover:border-indigo-300 transition-all duration-200">
                                                        <div class="flex items-center">
                                                            @if($component->icon)
                                                                <i class="{{ $component->icon }} text-xl text-indigo-600 mr-3"></i>
                                                            @else
                                                                <i class="fas fa-link text-xl text-indigo-600 mr-3"></i>
                                                            @endif
                                                            <div class="flex-1 text-left">
                                                                <h3 class="font-medium text-gray-900">{{ $component->name }}</h3>
                                                                @if($component->content)
                                                                    <p class="text-sm text-gray-500">{{ $component->content }}</p>
                                                                @endif
                                                            </div>
                                                            <i class="fas fa-chevron-right text-gray-400"></i>
                                                        </div>
                                                    </a>
                                                    @break
                                                    
                                                @case('phone')
                                                    <a href="tel:{{ $component->content }}" 
                                                       class="block w-full p-4 bg-gray-50 hover:bg-green-50 rounded-xl border border-gray-200 hover:border-green-300 transition-all duration-200">
                                                        <div class="flex items-center">
                                                            @if($component->icon)
                                                                <i class="{{ $component->icon }} text-xl text-green-600 mr-3"></i>
                                                            @else
                                                                <i class="fas fa-phone text-xl text-green-600 mr-3"></i>
                                                            @endif
                                                            <div class="flex-1 text-left">
                                                                <h3 class="font-medium text-gray-900">{{ $component->name }}</h3>
                                                                <p class="text-sm text-gray-500">{{ $component->content }}</p>
                                                            </div>
                                                            <i class="fas fa-chevron-right text-gray-400"></i>
                                                        </div>
                                                    </a>
                                                    @break
                                                    
                                                @case('email')
                                                    <a href="mailto:{{ $component->content }}" 
                                                       class="block w-full p-4 bg-gray-50 hover:bg-blue-50 rounded-xl border border-gray-200 hover:border-blue-300 transition-all duration-200">
                                                        <div class="flex items-center">
                                                            @if($component->icon)
                                                                <i class="{{ $component->icon }} text-xl text-blue-600 mr-3"></i>
                                                            @else
                                                                <i class="fas fa-envelope text-xl text-blue-600 mr-3"></i>
                                                            @endif
                                                            <div class="flex-1 text-left">
                                                                <h3 class="font-medium text-gray-900">{{ $component->name }}</h3>
                                                                <p class="text-sm text-gray-500">{{ $component->content }}</p>
                                                            </div>
                                                            <i class="fas fa-chevron-right text-gray-400"></i>
                                                        </div>
                                                    </a>
                                                    @break
                                                    
                                                @case('map')
                                                    <a href="https://maps.google.com/?q={{ urlencode($component->content) }}" 
                                                       target="_blank"
                                                       class="block w-full p-4 bg-gray-50 hover:bg-red-50 rounded-xl border border-gray-200 hover:border-red-300 transition-all duration-200">
                                                        <div class="flex items-center">
                                                            @if($component->icon)
                                                                <i class="{{ $component->icon }} text-xl text-red-600 mr-3"></i>
                                                            @else
                                                                <i class="fas fa-map-marker-alt text-xl text-red-600 mr-3"></i>
                                                            @endif
                                                            <div class="flex-1 text-left">
                                                                <h3 class="font-medium text-gray-900">{{ $component->name }}</h3>
                                                                <p class="text-sm text-gray-500">{{ $component->content }}</p>
                                                            </div>
                                                            <i class="fas fa-external-link-alt text-gray-400"></i>
                                                        </div>
                                                    </a>
                                                    @break
                                                    
                                                @case('social')
                                                    <a href="{{ $component->config['url'] ?? '#' }}" 
                                                       target="_blank"
                                                       class="block w-full p-4 bg-gray-50 hover:bg-purple-50 rounded-xl border border-gray-200 hover:border-purple-300 transition-all duration-200">
                                                        <div class="flex items-center">
                                                            @if($component->icon)
                                                                <i class="{{ $component->icon }} text-xl text-purple-600 mr-3"></i>
                                                            @else
                                                                <i class="fab fa-{{ strtolower($component->name) }} text-xl text-purple-600 mr-3"></i>
                                                            @endif
                                                            <div class="flex-1 text-left">
                                                                <h3 class="font-medium text-gray-900">{{ $component->name }}</h3>
                                                                @if($component->config['username'] ?? false)
                                                                    <p class="text-sm text-gray-500">@{{ $component->config['username'] }}</p>
                                                                @endif
                                                            </div>
                                                            <i class="fas fa-external-link-alt text-gray-400"></i>
                                                        </div>
                                                    </a>
                                                    @break
                                                    
                                                @case('text')
                                                    <div class="w-full p-4 bg-gray-50 rounded-xl border border-gray-200">
                                                        <div class="flex items-center">
                                                            @if($component->icon)
                                                                <i class="{{ $component->icon }} text-xl text-gray-600 mr-3"></i>
                                                            @else
                                                                <i class="fas fa-info-circle text-xl text-gray-600 mr-3"></i>
                                                            @endif
                                                            <div class="flex-1 text-left">
                                                                <h3 class="font-medium text-gray-900">{{ $component->name }}</h3>
                                                                @if($component->content)
                                                                    <p class="text-sm text-gray-700">{{ $component->content }}</p>
                                                                @endif
                                                            </div>
                                                        </div>
                                                    </div>
                                                    @break
                                                    
                                                @default
                                                    <div class="w-full p-4 bg-gray-50 rounded-xl border border-gray-200">
                                                        <div class="flex items-center">
                                                            <i class="fas fa-cube text-xl text-gray-600 mr-3"></i>
                                                            <div class="flex-1 text-left">
                                                                <h3 class="font-medium text-gray-900">{{ $component->name }}</h3>
                                                                @if($component->content)
                                                                    <p class="text-sm text-gray-700">{{ $component->content }}</p>
                                                                @endif
                                                            </div>
                                                        </div>
                                                    </div>
                                            @endswitch
                                        </div>
                                    @endif
                                @endforeach
                            </div>
                        </div>
                    @endif
                    
                    <!-- Footer -->
                    <div class="px-6 py-4 bg-gray-50 border-t border-gray-200">
                        <div class="text-center">
                            <p class="text-xs text-gray-500">
                                Powered by <span class="font-medium">CardKits</span>
                            </p>
                        </div>
                    </div>
                </div>
                
                <!-- Social Media Links (if any) -->
                @if($digitalCard->linkedin || $digitalCard->website)
                    <div class="mt-6 flex justify-center space-x-4">
                        @if($digitalCard->linkedin)
                            <a href="{{ $digitalCard->linkedin }}" 
                               target="_blank"
                               class="social-icon w-12 h-12 bg-blue-600 text-white rounded-full flex items-center justify-center hover:bg-blue-700 transition-colors duration-200">
                                <i class="fab fa-linkedin-in text-lg"></i>
                            </a>
                        @endif
                        
                        @if($digitalCard->website)
                            <a href="{{ $digitalCard->website }}" 
                               target="_blank"
                               class="social-icon w-12 h-12 bg-gray-600 text-white rounded-full flex items-center justify-center hover:bg-gray-700 transition-colors duration-200">
                                <i class="fas fa-globe text-lg"></i>
                            </a>
                        @endif
                    </div>
                @endif
                
                <!-- Share Button -->
                <div class="mt-6 text-center">
                    <button onclick="shareCard()" 
                            class="inline-flex items-center px-6 py-3 bg-indigo-600 text-white font-medium rounded-lg hover:bg-indigo-700 transition-colors duration-200">
                        <i class="fas fa-share-alt mr-2"></i>
                        Share Card
                    </button>
                </div>
            </div>
        </div>
    </div>
    
    <!-- JavaScript -->
    <script>
        // Share functionality
        function shareCard() {
            if (navigator.share) {
                navigator.share({
                    title: '{{ $digitalCard->name }} - {{ $digitalCard->title }}',
                    text: '{{ $digitalCard->bio ?? "Check out my digital business card" }}',
                    url: '{{ $digitalCard->public_url }}'
                });
            } else {
                // Fallback for browsers that don't support Web Share API
                const url = '{{ $digitalCard->public_url }}';
                navigator.clipboard.writeText(url).then(() => {
                    alert('Card URL copied to clipboard!');
                }).catch(() => {
                    // Fallback for older browsers
                    const textArea = document.createElement('textarea');
                    textArea.value = url;
                    document.body.appendChild(textArea);
                    textArea.select();
                    document.execCommand('copy');
                    document.body.removeChild(textArea);
                    alert('Card URL copied to clipboard!');
                });
            }
        }
        
        // Add to home screen functionality
        let deferredPrompt;
        
        window.addEventListener('beforeinstallprompt', (e) => {
            e.preventDefault();
            deferredPrompt = e;
            
            // Show install button if you want
            // You can add a button here to prompt installation
        });
        
        // Track time on page for analytics
        let startTime = Date.now();
        
        window.addEventListener('beforeunload', () => {
            const timeOnPage = Date.now() - startTime;
            
            // Send analytics data if needed
            if (navigator.sendBeacon) {
                const data = new FormData();
                data.append('time_on_page', timeOnPage);
                data.append('action', 'page_exit');
                navigator.sendBeacon('{{ route("digital-card.analytics") }}', data);
            }
        });
    </script>
</body>
</html>