## Laravel Project Deployment Guide

#### Install Dependencies

```
composer install
```

#### Set Up Environment Variables

```
cp .env.example .env
```

#### Generate the application key:

```
php artisan key:generate
```

#### Configure Database

```
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=your_database_name
DB_USERNAME=your_database_user
DB_PASSWORD=your_database_password
```

#### Run the database migrations:

```
php artisan migrate --seed
```

#### Run:

```
php artisan queue:work
```

```
php artisan schedule:work
```

#### Serve Application

```
php artisan serve
```

#### API Documentation

```
http://127.0.0.1:8000/api/documentation
```

#### Authentication

##### Admin User Credentials

```
"email":"admin@test.com",
"password":"123"
```

##### Non-admin User Credentials

```
"email":"user@test.com",
"password":"123"
```

**Note:** You can uncomment commented lines in `app/Services/PaymentRequestService.php` to have the full functionality but it requires correct email configuration for application and real emails for users. Also, real API endpoints for banks.
