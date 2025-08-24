<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $bioLink->title }}</title>
    
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&family=Roboto:wght@300;400;500;700&family=Open+Sans:wght@300;400;500;600;700&family=Lato:wght@300;400;700&family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    
    <style>
        body {
            font-family: '{{ $bioLink->font_family }}', sans-serif;
            margin: 0;
            padding: 0;
            background: linear-gradient(135deg, {{ $bioLink->theme_color }} 0%, {{ $bioLink->button_color }} 100%);
            min-height: 100vh;
            color: {{ $bioLink->text_color }};
        }
        
        .container {
            max-width: 600px;
            margin: 0 auto;
            padding: 20px;
        }
        
        .profile-section {
            text-align: center;
            margin-bottom: 40px;
        }
        
        .profile-photo {
            width: 120px;
            height: 120px;
            border-radius: 50%;
            border: 4px solid rgba(255, 255, 255, 0.3);
            margin: 0 auto 20px;
            object-fit: cover;
            box-shadow: 0 8px 32px rgba(0, 0, 0, 0.1);
        }
        
        .profile-placeholder {
            width: 120px;
            height: 120px;
            border-radius: 50%;
            border: 4px solid rgba(255, 255, 255, 0.3);
            margin: 0 auto 20px;
            background: rgba(255, 255, 255, 0.2);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 48px;
            color: rgba(255, 255, 255, 0.8);
        }
        
        .title {
            font-size: 28px;
            font-weight: 700;
            margin-bottom: 10px;
            color: {{ $bioLink->text_color }};
        }
        
        .description {
            font-size: 16px;
            line-height: 1.6;
            margin-bottom: 30px;
            opacity: 0.9;
            color: {{ $bioLink->text_color }};
        }
        
        .links-section {
            margin-bottom: 40px;
        }
        
        .link-item {
            background: rgba(255, 255, 255, 0.15);
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.2);
            border-radius: 12px;
            padding: 16px 20px;
            margin-bottom: 16px;
            text-decoration: none;
            display: block;
            transition: all 0.3s ease;
            color: {{ $bioLink->text_color }};
        }
        
        .link-item:hover {
            background: rgba(255, 255, 255, 0.25);
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(0, 0, 0, 0.15);
        }
        
        .link-content {
            display: flex;
            align-items: center;
            justify-content: space-between;
        }
        
        .link-left {
            display: flex;
            align-items: center;
            gap: 12px;
        }
        
        .link-icon {
            width: 24px;
            height: 24px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 16px;
        }
        
        .link-text {
            font-weight: 500;
            font-size: 16px;
        }
        
        .link-arrow {
            opacity: 0.7;
            transition: transform 0.3s ease;
        }
        
        .link-item:hover .link-arrow {
            transform: translateX(4px);
        }
        
        .social-section {
            text-align: center;
        }
        
        .social-title {
            font-size: 18px;
            font-weight: 600;
            margin-bottom: 20px;
            opacity: 0.9;
        }
        
        .social-icons {
            display: flex;
            justify-content: center;
            gap: 16px;
        }
        
        .social-icon {
            width: 48px;
            height: 48px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 20px;
            color: white;
            text-decoration: none;
            transition: all 0.3s ease;
        }
        
        .social-icon:hover {
            transform: scale(1.1);
            box-shadow: 0 8px 25px rgba(0, 0, 0, 0.2);
        }
        
        .footer {
            text-align: center;
            margin-top: 60px;
            padding: 20px;
            opacity: 0.7;
            font-size: 14px;
        }
        
        @media (max-width: 768px) {
            .container {
                padding: 16px;
            }
            
            .title {
                font-size: 24px;
            }
            
            .profile-photo,
            .profile-placeholder {
                width: 100px;
                height: 100px;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <!-- Profile Section -->
        <div class="profile-section">
            @if($bioLink->profile_photo)
                <img src="{{ Storage::url($bioLink->profile_photo) }}" alt="{{ $bioLink->title }}" class="profile-photo">
            @else
                <div class="profile-placeholder">
                    <i class="fas fa-user"></i>
                </div>
            @endif
            
            <h1 class="title">{{ $bioLink->title }}</h1>
            
            @if($bioLink->description)
                <p class="description">{{ $bioLink->description }}</p>
            @endif
        </div>

        <!-- Links Section -->
        @if($bioLink->items->count() > 0)
            <div class="links-section">
                @foreach($bioLink->items as $item)
                    <a href="{{ route('bio.click', ['slug' => $bioLink->slug, 'itemId' => $item->id]) }}" 
                       class="link-item" 
                       target="{{ $item->open_in_new_tab ? '_blank' : '_self' }}">
                        <div class="link-content">
                            <div class="link-left">
                                <div class="link-icon">
                                    @if($item->icon)
                                        <i class="{{ $item->icon }}"></i>
                                    @else
                                        <i class="fas fa-link"></i>
                                    @endif
                                </div>
                                <div class="link-text">{{ $item->title }}</div>
                            </div>
                            <div class="link-arrow">
                                <i class="fas fa-arrow-right"></i>
                            </div>
                        </div>
                    </a>
                @endforeach
            </div>
        @endif

        <!-- Social Media Section -->
        @if($bioLink->show_social_icons && $bioLink->socialMedia->count() > 0)
            <div class="social-section">
                <h3 class="social-title">Follow Me</h3>
                <div class="social-icons">
                    @foreach($bioLink->socialMedia as $social)
                        <a href="{{ $social->url }}" 
                           class="social-icon" 
                           target="_blank" 
                           style="background-color: {{ $social->platform_color }}"
                           title="{{ ucfirst($social->platform) }}">
                            <i class="{{ $social->platform_icon }}"></i>
                        </a>
                    @endforeach
                </div>
            </div>
        @endif

        <!-- Footer -->
        <div class="footer">
            <p>Powered by {{ config('app.name', 'Laravel') }}</p>
        </div>
    </div>
</body>
</html>