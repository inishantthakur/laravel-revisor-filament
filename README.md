# Robust Draft, Publishing & Versioning for Laravel Filament Resources

[![Latest Version on Packagist](https://img.shields.io/packagist/v/indracollective/laravel-revisor-filament.svg?style=flat-square)](https://packagist.org/packages/indracollective/laravel-revisor-filament)
[![GitHub Tests Action Status](https://img.shields.io/github/actions/workflow/status/indracollective/laravel-revisor-filament/run-tests.yml?branch=main&label=tests&style=flat-square)](https://github.com/indracollective/laravel-revisor-filament/actions?query=workflow%3Arun-tests+branch%3Amain)
[![GitHub Code Style Action Status](https://img.shields.io/github/actions/workflow/status/indracollective/laravel-revisor-filament/fix-php-code-styling.yml?branch=main&label=code%20style&style=flat-square)](https://github.com/indracollective/laravel-revisor-filament/actions?query=workflow%3A"Fix+PHP+code+styling"+branch%3Amain)
[![Total Downloads](https://img.shields.io/packagist/dt/indracollective/laravel-revisor-filament.svg?style=flat-square)](https://packagist.org/packages/indracollective/laravel-revisor-filament)



This is where your description should go. Limit it to a paragraph or two. Consider adding a small example.

## Installation

You can install the package via composer:

```bash
composer require indracollective/laravel-revisor-filament
```

You can publish and run the migrations with:

```bash
php artisan vendor:publish --tag="laravel-revisor-filament-migrations"
php artisan migrate
```

You can publish the config file with:

```bash
php artisan vendor:publish --tag="laravel-revisor-filament-config"
```

Optionally, you can publish the views using

```bash
php artisan vendor:publish --tag="laravel-revisor-filament-views"
```

This is the contents of the published config file:

```php
return [
];
```

## Usage

```php
$revisorFilament = new Indra\RevisorFilament();
echo $revisorFilament->echoPhrase('Hello, Indra!');
```

## Testing

```bash
composer test
```

## Changelog

Please see [CHANGELOG](CHANGELOG.md) for more information on what has changed recently.

## Contributing

Please see [CONTRIBUTING](.github/CONTRIBUTING.md) for details.

## Security Vulnerabilities

Please review [our security policy](../../security/policy) on how to report security vulnerabilities.

## Credits

- [Shea Dawson](https://github.com/indracollective)
- [All Contributors](../../contributors)

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.
