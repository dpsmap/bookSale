# Book Sale Platform

A Laravel 10 web application for selling books with payment proof verification and secure downloads.

## Features

- **Order Management**: Customers can place orders with payment proof uploads
- **Receipt Codes**: Unique 8-character receipt codes (XXXX-XXXX format) for order tracking
- **Magic Links**: Secure direct links to order status pages
- **Admin Dashboard**: Complete order management with status updates
- **Secure Downloads**: Private file storage with signed URLs for verified orders
- **Anti-Abuse**: Honeypot fields, duplicate file detection, and rate limiting ready
- **Responsive Design**: Modern UI using Tailwind CSS and Alpine.js

## Requirements

- PHP 8.1+
- MySQL 5.7+ or 8.0+
- Laravel 10
- Web server (Apache/Nginx)

## Installation

1. **Setup Environment**
   ```bash
   cd /var/www/app/bookSale
   composer install
   php artisan key:generate
   ```

2. **Database Configuration**
   ```bash
   # Database is already configured in .env:
   DB_DATABASE=bookSale
   DB_USERNAME=root
   DB_PASSWORD=linhtutkyaw
   
   # Run migrations and seeders
   php artisan migrate
   php artisan db:seed --class=SettingSeeder
   ```

3. **Storage Setup**
   ```bash
   php artisan storage:link
   mkdir -p storage/app/private/books
   ```

4. **Admin Credentials**
   ```bash
   # Already configured in .env:
   ADMIN_USERNAME=admin
   ADMIN_PASSWORD=admin123
   ```

## Usage

### For Customers

1. **Visit Homepage**: View book status and availability
2. **Place Order**: Fill out the order form and upload payment proof
3. **Track Order**: Use receipt code or magic link to check status
4. **Download**: Access book files once order is verified and book is published

### For Admins

1. **Login**: Access `/admin` with credentials (admin/admin123)
2. **Dashboard**: View order statistics and manage orders
3. **Order Management**: 
   - Verify/reject orders
   - Mark orders as read
   - View order details
   - Delete orders if needed
4. **Settings**: Configure book availability and file paths

## File Storage

### Payment Proofs
- Stored in: `storage/app/public/payment_proofs/`
- Publicly accessible (for admin viewing)

### Book Files
- Stored in: `storage/app/private/`
- Private access only (via download endpoints)
- Configure paths in admin settings

## Security Features

- **Honeypot Fields**: Prevents bot submissions
- **Duplicate Detection**: SHA-256 hash checking for payment proofs
- **Private Storage**: Book files never publicly accessible
- **Token-based Admin Auth**: Simple in-memory token system
- **Input Validation**: Comprehensive validation on all inputs

## Running the Application

```bash
php artisan serve
```

Then visit:
- Homepage: `http://localhost:8000`
- Admin: `http://localhost:8000/admin`

## Book Setup

1. Upload book files to `storage/app/private/books/`
2. Login to admin panel (`/admin`)
3. Go to Settings
4. Configure:
   - Enable "Book Published"
   - Set PDF file key: `books/your-book.pdf`
   - Set EPUB file key: `books/your-book.epub`
   - Set display filenames

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

- **[Vehikl](https://vehikl.com/)**
- **[Tighten Co.](https://tighten.co)**
- **[WebReinvent](https://webreinvent.com/)**
- **[Kirschbaum Development Group](https://kirschbaumdevelopment.com)**
- **[64 Robots](https://64robots.com)**
- **[Curotec](https://www.curotec.com/services/technologies/laravel/)**
- **[Cyber-Duck](https://cyber-duck.co.uk)**
- **[DevSquad](https://devsquad.com/hire-laravel-developers)**
- **[Jump24](https://jump24.co.uk)**
- **[Redberry](https://redberry.international/laravel/)**
- **[Active Logic](https://activelogic.com)**
- **[byte5](https://byte5.de)**
- **[OP.GG](https://op.gg)**

## Contributing

Thank you for considering contributing to the Laravel framework! The contribution guide can be found in the [Laravel documentation](https://laravel.com/docs/contributions).

## Code of Conduct

In order to ensure that the Laravel community is welcoming to all, please review and abide by the [Code of Conduct](https://laravel.com/docs/contributions#code-of-conduct).

## Security Vulnerabilities

If you discover a security vulnerability within Laravel, please send an e-mail to Taylor Otwell via [taylor@laravel.com](mailto:taylor@laravel.com). All security vulnerabilities will be promptly addressed.

## License

The Laravel framework is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).
