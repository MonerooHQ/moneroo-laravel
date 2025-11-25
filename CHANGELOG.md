# Changelog

All notable changes to `moneroo-laravel` will be documented in this file.

## 0.2.0 - 2025-11-25

### Added
- Laravel 12 support
- PHP 8.3 support in CI tests

### Changed
- Updated `illuminate/contracts` to support Laravel 9-12 (^9.0 || ^10.0 || ^11.0 || ^12.0)
- Updated PHPUnit to support versions 9.6-11.0 for multi-version compatibility
- Updated Orchestra Testbench to support versions 7.40-10.0
- Updated Larastan to support versions 2.9-3.0 for Laravel 9-12 compatibility
- Updated PHPStan extensions (phpstan-deprecation-rules, phpstan-phpunit) to support PHPStan 1.x and 2.x
- Updated Nunomaduro Collision to support versions 6.0-8.0
- Updated Carbon version constraints to ^2.72.6 and ^3.8.4 (fixes CVE-2025-22145 security advisory)
- Migrated PHPUnit configuration to PHPUnit 10+ schema
- Updated CI workflow to test Laravel 9, 10, 11, and 12 with PHP 8.1, 8.2, and 8.3

### Removed
- Removed `insolita/unused-scanner` package (incompatible with Symfony 7 required by Laravel 11+)
- Removed `unused` composer script
- Removed code coverage configuration from phpunit.xml.dist

### Fixed
- Fixed PHPUnit 10+ compatibility by adding `$latestResponse` property to TestCase
- Fixed test failures with Orchestra Testbench 8+
- Fixed PHPUnit test runner warning about missing coverage driver

### Security
- Updated Carbon to address CVE-2025-22145 arbitrary file inclusion vulnerability

## 0.1.2 - 2025-01-31
- CI: update Carbon version for Laravel tests

## 1.0.0 - 2023-08-22
  - Initial release