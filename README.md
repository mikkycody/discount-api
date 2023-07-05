# Laravel Discount API Implementation

A simple product discount api implementation

## Table of Contents

-   [Technologies](#technologies)
-   [Getting Started](#getting-started)
    -   [Installation](#installation)
    -   [Deployment](#deployment)
    -   [Usage](#usage)
## Technologies

-   [Laravel](https://laravel.com/) - PHP web framework

This project runs on Laravel 10 and requires PHP 8.1+ .

## Getting Started

### Installation

-   git clone
    [Laravel Discount API Implementation](https://github.com/mikkycody/discount-api.git)
-   Run `composer install` to install packages .
-   Copy .env.example file, create a .env file if not created and edit database credentials there (MYSQL / POSTGRES).
-   Run `php artisan migrate` to run database migrations.
-   Run `php artisan db:seed` to populate products.
-   Run `php artisan serve` to start the server (Ignore if using valet) .
-   Run `php artisan test` to run tests (set up sqlite or edit .env.testing db connection variables).

