# CardKits.id - Digital Business Card Builder

A modern web application for creating and sharing digital business cards, built with Laravel, React.js, and Tailwind CSS.

## Features

- 🎨 **Beautiful Templates**: Multiple professional card templates
- 📱 **Responsive Design**: Works perfectly on all devices
- 🔗 **Easy Sharing**: Share cards via QR codes, social media, or direct links
- 📊 **Analytics**: Track views, shares, and engagement
- 👤 **User Management**: Complete user authentication and profile management
- 🎯 **vCard Export**: Download contact information in vCard format
- 🌈 **Customizable**: Choose from multiple color schemes and templates

## Tech Stack

- **Backend**: Laravel 12 (PHP)
- **Frontend**: React.js 18 with React Router
- **Styling**: Tailwind CSS
- **Database**: SQLite (can be configured for MySQL/PostgreSQL)
- **Authentication**: Laravel Sanctum
- **Build Tool**: Vite

## Prerequisites

- PHP 8.2 or higher
- Node.js 18 or higher
- Composer
- npm or yarn

## Installation

1. **Clone the repository**
   ```bash
   git clone <repository-url>
   cd cardkits-id
   ```

2. **Install PHP dependencies**
   ```bash
   composer install
   ```

3. **Install Node.js dependencies**
   ```bash
   npm install
   ```

4. **Environment setup**
   ```bash
   cp .env.example .env
   php artisan key:generate
   ```

5. **Database setup**
   ```bash
   php artisan migrate
   ```

6. **Build frontend assets**
   ```bash
   npm run build
   ```

7. **Start the development server**
   ```bash
   php artisan serve
   ```

8. **Start Vite development server (for development)**
   ```bash
   npm run dev
   ```

## Usage

### Creating a Digital Business Card

1. Register an account or sign in
2. Click "Create New Card" on the dashboard
3. Fill in your personal and professional information
4. Choose a template and color scheme
5. Upload a profile photo (optional)
6. Preview and save your card

### Sharing Your Card

- **Direct Link**: Share the unique URL of your card
- **QR Code**: Generate a QR code for easy mobile sharing
- **Social Media**: Share directly to WhatsApp, Telegram, Twitter, Facebook, or LinkedIn
- **vCard**: Download contact information in vCard format

### Managing Your Cards

- View all your cards on the dashboard
- Edit card information anytime
- Track views, shares, and downloads
- Delete cards you no longer need

## API Endpoints

### Authentication
- `POST /api/register` - User registration
- `POST /api/login` - User login
- `POST /api/logout` - User logout (authenticated)

### Cards
- `GET /api/cards` - Get user's cards (authenticated)
- `POST /api/cards` - Create new card (authenticated)
- `GET /api/cards/{id}` - Get specific card
- `PUT /api/cards/{id}` - Update card (authenticated)
- `DELETE /api/cards/{id}` - Delete card (authenticated)
- `GET /api/cards/{id}/view` - Public card view
- `GET /api/cards/{id}/stats` - Get card statistics (authenticated)
- `POST /api/cards/{id}/share` - Record share (authenticated)

### User Profile
- `GET /api/user` - Get current user (authenticated)
- `PUT /api/profile` - Update profile (authenticated)
- `POST /api/profile/photo` - Update profile photo (authenticated)
- `PUT /api/profile/password` - Update password (authenticated)

## Project Structure

```
cardkits-id/
├── app/
│   ├── Http/Controllers/
│   │   ├── Auth/AuthController.php
│   │   ├── CardController.php
│   │   └── UserController.php
│   └── Models/
│       ├── User.php
│       └── Card.php
├── database/migrations/
│   ├── create_cards_table.php
│   └── add_bio_and_photo_to_users_table.php
├── resources/
│   ├── js/
│   │   ├── components/
│   │   │   ├── Auth/
│   │   │   ├── Layout/
│   │   │   ├── Dashboard.jsx
│   │   │   ├── CardBuilder.jsx
│   │   │   ├── CardPreview.jsx
│   │   │   ├── Profile.jsx
│   │   │   └── Settings.jsx
│   │   ├── contexts/
│   │   │   ├── AuthContext.jsx
│   │   │   └── CardContext.jsx
│   │   ├── App.jsx
│   │   └── app.jsx
│   ├── css/
│   │   └── app.css
│   └── views/
│       └── app.blade.php
├── routes/
│   ├── api.php
│   └── web.php
└── public/
    └── build/
```

## Customization

### Adding New Templates

1. Add template options in `CardBuilder.jsx`
2. Update the preview component to handle new templates
3. Add template styles in `app.css`

### Adding New Color Schemes

1. Add color scheme options in `CardBuilder.jsx`
2. Update the color schemes object in components
3. Add corresponding Tailwind classes

### Database Configuration

The application uses SQLite by default. To use MySQL or PostgreSQL:

1. Update `.env` file with your database credentials
2. Install the appropriate PHP database extension
3. Run migrations: `php artisan migrate`

## Contributing

1. Fork the repository
2. Create a feature branch
3. Make your changes
4. Add tests if applicable
5. Submit a pull request

## License

This project is licensed under the MIT License.

## Support

For support and questions, please open an issue on GitHub or contact the development team.

---

**CardKits.id** - Making professional networking digital and beautiful! 🚀