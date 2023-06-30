
# Moneroo Laravel SDK

[![Build Status](https://github.com/moneroo/moneroo-laravel/actions/workflows/ci.yml/badge.svg?branch=master)](https://github.com/moneroo/moneroo-laravel/actions?query=branch%3Amaster)
[![Latest Stable Version](https://poser.pugx.org/moneroo/moneroo-laravel/v/stable.svg)](https://packagist.org/packages/moneroo/moneroo-laravelp)
[![Total Downloads](https://poser.pugx.org/moneroo/moneroo-laravel/downloads.svg)](https://packagist.org/packages/moneroo/moneroo-laravel)
[![License](https://poser.pugx.org/moneroo/moneroo-laravel/license.svg)](https://packagist.org/packages/stripe/stripe-php)

The Moneroo Laravel SDK provides convenient access to the Moneroo API from applications written with Laravel Framework.


## Requirements
Laravel 7.0 or higher

## Installation

You can install the package via composer:

```bash  
composer require axazara/moneroo-laravel```  
  
### Installation Command  
The package provides a convenient command to install the Moneroo Laravel SDK and publish its configuration to your Laravel project. After you've installed the package via composer, you can run this command:  
  
```bash  
php artisan moneroo:install```  
  
This command will:  
  
1. Publish a `moneroo.php` file in your config directory  
2. Append your `.env` file with the `MONEROO_PUBLIC_KEY` and `MONEROO_SECRET_KEY` variables if they don't already exist.  
  
You will have to replace 'your-public-key' and 'your-secret-key' with your actual Moneroo public key and secret key respectively.  
```env  
  
MONEROO_PUBLIC_KEY=your-public-key  
MONEROO_SECRET_KEY=your-secret-key  
```  

Please keep in mind that these are sensitive keys and should not be publicly exposed. Laravel .env file is ignored by Git, which makes it a good place to store sensitive information.

## Getting Started

Simple usage looks like:

```php
$payment = new Moneroo\Payment();
$transaction = $payment->create([
    'amount' => 100,
    'currency' => 'USD',
    'customer' => [
        'email' => 'john.doe@example.com',
        'first_name' => 'John',
        'last_name' => 'Doe',
        'phone' => '123456789',
        'address' => '123 Main St',
        'city' => 'Los Angeles',
        'state' => 'CA',
        'country' => 'USA',
        'zip' => '90001',
    ],
    'description' => 'Payment for order #123',
    'return_url' => 'https://yourwebsite.com/thanks',
    'metadata' => [
        'order_id' => '123',
        'customer_id' => '456',
    ],
    'methods' => ['card', 'orange_ci'],
]);

// Or use Moneroo Helper function

$payment = monerooPayment()->create();
    'amount' => 100,
    'currency' => 'USD',
    'customer' => [
        'email' => 'john.doe@example.com',
        'first_name' => 'John',
        'last_name' => 'Doe',
        'phone' => '123456789',
        'address' => '123 Main St',
        'city' => 'Los Angeles',
        'state' => 'CA',
        'country' => 'USA',
        'zip' => '90001',
    ],
    'description' => 'Payment for order #123',
    'return_url' => 'https://yourwebsite.com/thanks',
    'metadata' => [
        'order_id' => '123',
        'customer_id' => '456',
    ],
    'methods' => ['card', 'orange_ci'],
]);
```

## Documentation

See the [PHP API docs](https://stripe.com/docs/api/?lang=php#intro).

See [video demonstrations][youtube-playlist] covering how to use the library.

## Development

Get [Composer][composer]. For example, on Mac OS:

```bash
brew install composer
```

Install dependencies:

```bash
composer install
```

The test suite depends on [stripe-mock], so make sure to fetch and run it from a
background terminal ([stripe-mock's README][stripe-mock] also contains
instructions for installing via Homebrew and other methods):

```bash
go install github.com/stripe/stripe-mock@latest
stripe-mock
```

Install dependencies as mentioned above (which will resolve [PHPUnit](http://packagist.org/packages/phpunit/phpunit)), then you can run the test suite:

```bash
./vendor/bin/phpunit
```

Or to run an individual test file:

```bash
./vendor/bin/phpunit tests/Stripe/UtilTest.php
```

Update bundled CA certificates from the [Mozilla cURL release][curl]:

```bash
./update_certs.php

```

The library uses [PHP CS Fixer][php-cs-fixer] for code formatting. Code must be formatted before PRs are submitted, otherwise CI will fail. Run the formatter with:

```bash
./vendor/bin/php-cs-fixer fix -v .
```

## Security Vulnerabilities

If you discover a security vulnerability within Moneroo Laravel SDK, please send an e-mail to Moneroo Security via [security@moneroo.com](mailto:security@moneroo.io). All security vulnerabilities will be promptly addressed.

## License

The Moneroo Laravel SDK is open-sourced software licensed under the [MIT license](LICENSE.md).


[composer]: https://getcomposer.org/
[php-cs-fixer]: https://github.com/FriendsOfPHP/PHP-CS-Fixer
[youtube-playlist]: https://www.youtube.com/playlist?list=PLy1nL-pvL2M6cUbiHrfMkXxZ9j9SGBxFE