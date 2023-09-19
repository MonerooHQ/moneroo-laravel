<div align="center">
<a href="https://moneroo.io" title="Moneroo - Payment stack for Africa">
    <img src="/art/cover.png" alt="Moneroo website">
</a>

# Moneroo Laravel SDK

<!-- Nav header - Start -->

<a href="https://join.slack.com/t/ballerine-oss/shared_invite/zt-1iu6otkok-OqBF3TrcpUmFd9oUjNs2iw">Slack</a>
·
<a href="https://www.moneroo.io/">Website</a>
·
<a href="https://www.moneroo.io/contact">Contact</a>
·
<a href="https://docs.moneroo.io/">Documentation</a>

<!-- Nav header - END -->

<!-- Badges - Start -->
[![PHP Version](https://img.shields.io/packagist/php-v/moneroo/moneroo-laravel.svg)](https://packagist.org/packages/moneroo/moneroo-laravel)
[![Build Status](https://github.com/moneroohq/moneroo-laravel/actions/workflows/run-tests.yml/badge.svg?branch=main)](https://github.com/moneroohq/moneroo-laravel/actions?query=branch%3Amain)
[![Latest Stable Version](https://poser.pugx.org/moneroohq/moneroo-laravel/v/stable.svg)](https://packagist.org/packages/moneroo/moneroo-laravel)
[![Total Downloads](https://poser.pugx.org/moneroo/moneroo-laravel/downloads.svg)](https://packagist.org/packages/moneroo/moneroo-laravel)
[![License](https://poser.pugx.org/moneroo/moneroo-laravel/license.svg)](https://packagist.org/packages/moneroo/moneroo-laravel)
<!-- Badges - END -->

</div>

## Requirements
Laravel 9 and later.
PHP Requirements: PHP 8.1 and later. (Not tested on PHP 8.0, but it should work)

For PHP 7.4 and 8.0 or Laravel 8 and below , please use the [moneroo-php](http://github.com/monerooHQ/moneroo-php) package.

## Installation

You can install the package via composer:

```shell
composer require moneroo/moneroo-laravel
```

### Configuration

After you've installed the package via composer, you can run this command:

```bash
php artisan moneroo:install
```

This command will:

1. Publish a `moneroo.php` file in your config directory
2. Append your `.env` file with the `MONEROO_PUBLIC_KEY` and `MONEROO_SECRET_KEY` variables if they don't already exist.

You will have to replace 'your-public-key' and 'your-secret-key' with your actual Moneroo public key and secret key respectively.

```env
MONEROO_PUBLIC_KEY=your-public-key
MONEROO_SECRET_KEY=your-secret-key
```

Please keep in mind that these are sensitive keys and should not be publicly exposed.
Laravel .env file is ignored by Git, which makes it a good place to store sensitive information.


## Documentation

See the Laravel SDK [documentation](https://docs.moneroo.io/).

## Development

1- Perform the tests
```shell
 composer test
```
2- Format and analyze your code before commit and push.
```shell
    composer format # Format your code with the required code style
    composer unused # check if there is an unused dependency
    composer analyze # Analyze your code with phpstan
```

### DEV Mode
You can set (or add) `moneroo.devMode` to `true` in your `config/moneroo.php` file to enable the dev mode.
After enabling the dev mode, you can set `moneroo.devBaseUrl` to customize the base URL of the Moneroo API you want to use.
In dev mode, the SDK will use the `moneroo.devBaseUrl` instead of the default base URL `https://api.moneroo.io`.

## Notes
- The project is based on the KISS principle.
- Each time you make a change, you must run the tests and format your code.
- Each time you make a change, you must update the documentation.
- Each time you make a change, you must update the changelog.
- Each time you make a change, you must add test cases.
- Each time you make a change, you must update the version number.
- Each time you make a change, you must update the API documentation.
- Each time you make a change, you must update the README.md file.

## Security Vulnerabilities

If you discover a security vulnerability within Moneroo Laravel SDK, please send an e-mail to Moneroo Security via [hello@moneroo.io](mailto:security@moneroo.io). All security vulnerabilities will be promptly addressed.

## License

The Moneroo Laravel SDK is open-sourced software licensed under the [MIT license](LICENSE.md).
