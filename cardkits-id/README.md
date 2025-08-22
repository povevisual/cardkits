<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400" alt="Laravel Logo"></a></p>

<p align="center">
<a href="https://github.com/laravel/framework/actions"><img src="https://github.com/laravel/framework/workflows/tests/badge.svg" alt="Build Status"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/dt/laravel/framework" alt="Total Downloads"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/v/laravel/framework" alt="Latest Stable Version"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/l/laravel/framework" alt="License"></a>
</p>

## About Laravel

Laravel is a web application framework with expressive, elegant syntax. We believe development must be an enjoyable and creative experience to be truly fulfilling. Laravel takes the pain out of development by easing common tasks used in many web projects, such as:

- [Simple, fast routing engine](https://laravel.com/docs/routing).
- [Powerful dependency injection container](https://laravel.com/docs/container).
- Multiple back-ends for [session](https://laravel.com/docs/session) and [cache](https://laravel.com/docs/cache) storage.
- Expressive, intuitive [database ORM](https://laravel.com/docs/eloquent).
- Database agnostic [schema migrations](https://laravel.com/docs/migrations).
- [Robust background job processing](https://laravel.com/docs/queues).
- [Real-time event broadcasting](https://laravel.com/docs/broadcasting).

Laravel is accessible, powerful, and provides tools required for large, robust applications.

## Learning Laravel

Laravel has the most extensive and thorough [documentation](https://laravel.com/docs) and video tutorial library of all modern web application frameworks, making it a breeze to get started with the framework.

You may also try the [Laravel Bootcamp](https://bootcamp.laravel.com), where you will be guided through building a modern Laravel application from scratch.

If you don't feel like reading, [Laracasts](https://laracasts.com) can help. Laracasts contains thousands of video tutorials on a range of topics including Laravel, modern PHP, unit testing, and JavaScript. Boost your skills by digging into our comprehensive video library.

## Laravel Sponsors

We would like to extend our thanks to the following sponsors for funding Laravel development. If you are interested in becoming a sponsor, please visit the [Laravel Partners program](https://partners.laravel.com).

### Premium Partners

- **[Vehikl](https://vehikl.com)**
- **[Tighten Co.](https://tighten.co)**
- **[Kirschbaum Development Group](https://kirschbaumdevelopment.com)**
- **[64 Robots](https://64robots.com)**
- **[Curotec](https://www.curotec.com/services/technologies/laravel)**
- **[DevSquad](https://devsquad.com/hire-laravel-developers)**
- **[Redberry](https://redberry.international/laravel-development)**
- **[Active Logic](https://activelogic.com)**

## Contributing

Thank you for considering contributing to the Laravel framework! The contribution guide can be found in the [Laravel documentation](https://laravel.com/docs/contributions).

## Code of Conduct

In order to ensure that the Laravel community is welcoming to all, please review and abide by the [Code of Conduct](https://laravel.com/docs/contributions#code-of-conduct).

## Security Vulnerabilities

If you discover a security vulnerability within Laravel, please send an e-mail to Taylor Otwell via [taylor@laravel.com](mailto:taylor@laravel.com). All security vulnerabilities will be promptly addressed.

## License

The Laravel framework is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).

# Bio Link - Laravel Application

A modern bio link application built with Laravel, similar to Linktree, that allows users to create beautiful, customizable bio link pages to share all their important links in one place.

## Features

### 🎨 **Customizable Design**
- **Theme Colors**: Customize background, text, and button colors
- **Font Selection**: Choose from multiple Google Fonts (Inter, Roboto, Open Sans, Lato, Poppins)
- **Profile & Background Photos**: Upload custom images for personalization
- **Responsive Design**: Mobile-first approach with beautiful animations

### 🔗 **Link Management**
- **Multiple Link Types**: Support for regular links, social media, email, phone, files, and text
- **Custom Icons**: Font Awesome icon support for each link
- **Link Ordering**: Drag and drop to reorder links
- **Click Tracking**: Analytics for each individual link

### 📱 **Social Media Integration**
- **15+ Platforms**: Instagram, Facebook, Twitter, YouTube, TikTok, LinkedIn, GitHub, Spotify, Twitch, Discord, Telegram, WhatsApp, Snapchat, Pinterest, Reddit
- **Auto-styling**: Platform-specific colors and icons
- **Username Management**: Easy social media profile linking

### 📊 **Analytics & Insights**
- **View Tracking**: Count page visits and unique visitors
- **Click Analytics**: Track individual link performance
- **Device Detection**: Mobile, tablet, and desktop analytics
- **Geographic Data**: Country and city tracking (when available)
- **Referrer Tracking**: See where your traffic comes from

### 🚀 **Advanced Features**
- **Custom Domains**: Use your own domain for bio links
- **SEO Optimized**: Meta tags and structured data
- **Social Sharing**: Easy sharing on social platforms
- **Status Management**: Activate/deactivate bio links
- **Bulk Operations**: Manage multiple bio links efficiently

## Installation

### Prerequisites
- PHP 8.1 or higher
- MySQL 8.0 or higher
- Composer
- Node.js & NPM (for frontend assets)

### Setup Steps

1. **Clone the repository**
   ```bash
   git clone <repository-url>
   cd cardkits-id
   ```

2. **Install dependencies**
   ```bash
   composer install
   npm install
   ```

3. **Environment configuration**
   ```bash
   cp .env.example .env
   php artisan key:generate
   ```

4. **Database setup**
   ```bash
   php artisan migrate
   php artisan db:seed --class=BioLinkSeeder
   ```

5. **Storage setup**
   ```bash
   php artisan storage:link
   ```

6. **Start the application**
   ```bash
   php artisan serve
   ```

## Usage

### Creating Your First Bio Link

1. **Register/Login**: Create an account or sign in
2. **Create Bio Link**: Click "Create New Bio Link"
3. **Customize**: Set title, description, colors, and fonts
4. **Add Links**: Include your important links and social media
5. **Upload Media**: Add profile and background photos
6. **Publish**: Your bio link is now live!

### Managing Bio Links

- **Dashboard**: View all your bio links in one place
- **Edit**: Modify design, links, and settings anytime
- **Analytics**: Track performance and visitor insights
- **Share**: Get shareable links for social media

### Public Bio Link Pages

Your bio links are accessible at:
- `https://yourdomain.com/bio/{slug}`
- Custom domain (if configured): `https://yourdomain.com`

## Database Structure

### Core Tables

- **`bio_links`**: Main bio link profiles
- **`bio_link_items`**: Individual links within bio links
- **`bio_link_social_media`**: Social media connections
- **`bio_link_analytics`**: Visitor and click tracking

### Key Relationships

- Users can have multiple bio links
- Each bio link can have multiple items and social media
- Analytics track both profile views and individual link clicks

## API Endpoints

### Public Routes
- `GET /bio/{slug}` - View public bio link page
- `GET /bio/{slug}/click/{itemId}` - Track link clicks

### Protected Routes
- `GET /bio-links` - List user's bio links
- `POST /bio-links` - Create new bio link
- `GET /bio-links/{id}` - View bio link details
- `PUT /bio-links/{id}` - Update bio link
- `DELETE /bio-links/{id}` - Delete bio link

## Customization

### Themes
The application supports custom themes through:
- CSS custom properties
- Tailwind CSS classes
- Dynamic color schemes

### Fonts
Available Google Fonts:
- Inter (default)
- Roboto
- Open Sans
- Lato
- Poppins

### Icons
Font Awesome 6.0 icons are supported for:
- Link types
- Social media platforms
- UI elements

## Security Features

- **Authentication**: Laravel's built-in auth system
- **Authorization**: Policy-based access control
- **CSRF Protection**: Automatic CSRF token validation
- **Input Validation**: Comprehensive form validation
- **File Upload Security**: Secure image upload handling

## Performance

- **Database Indexing**: Optimized queries with proper indexes
- **Caching**: Laravel's caching system for improved performance
- **Image Optimization**: Automatic image processing and storage
- **Lazy Loading**: Efficient data loading for better UX

## Contributing

1. Fork the repository
2. Create a feature branch
3. Make your changes
4. Add tests if applicable
5. Submit a pull request

## License

This project is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).

## Support

For support and questions:
- Create an issue on GitHub
- Check the documentation
- Contact the development team

## Demo

Try the live demo with sample data:
- **Demo User**: demo@example.com
- **Password**: password

Sample bio links:
- John Doe: `/bio/john-doe`
- Sarah Smith: `/bio/sarah-smith`

---

Built with ❤️ using Laravel and modern web technologies.
