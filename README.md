# Test Task Tech Castle

## Requirements

- **PHP Version**: ^8.2
- **Laravel Version**: ^12.0
- **Packages Used**:
    - `laravel/sanctum` (^4.0) - API authentication
    - `spatie/laravel-permission` (^6.16) - Role and permission management

## Installation

1. Clone the repository:
   ```sh
   git clone https://github.com/ggorr13/Tech-Castle.git
   cd tech-castle
   ```

2. Install dependencies:
   ```sh
   composer install
   ```

3. Copy the `.env.example` file to `.env` and configure your environment settings:
   ```sh
   cp .env.example .env
   ```

4. Generate the application key:
   ```sh
   php artisan key:generate
   ```

5. Run migrations and seeders:
   ```sh
   php artisan migrate --seed
   ```

6. Start the development server:
   ```sh
   php artisan serve
   ```
   

## API Authentication

This project uses Laravel Sanctum for authentication. To obtain an authentication token, send a request to:
```sh
  POST /api/login
```
email: admin@gmail.com, password: password

## User Roles & Permissions

Roles and permissions are managed using [Spatie Laravel Permission](https://spatie.be/docs/laravel-permission/v6/introduction). The default seed includes basic roles.

## License

This project is licensed under the MIT License.

