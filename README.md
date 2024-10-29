# Revisor Filament

[![Latest Version on Packagist](https://img.shields.io/packagist/v/indracollective/laravel-revisor-filament.svg?style=flat-square)](https://packagist.org/packages/indracollective/laravel-revisor-filament)
[![GitHub Tests Action Status](https://img.shields.io/github/actions/workflow/status/indracollective/laravel-revisor-filament/run-tests.yml?branch=main&label=tests&style=flat-square)](https://github.com/indracollective/laravel-revisor-filament/actions?query=workflow%3Arun-tests+branch%3Amain)
[![GitHub Code Style Action Status](https://img.shields.io/github/actions/workflow/status/indracollective/laravel-revisor-filament/fix-php-code-style-issues.yml?branch=main&label=code%20style&style=flat-square)](https://github.com/indracollective/laravel-revisor-filament/actions?query=workflow%3A"Fix+PHP+code+style+issues"+branch%3Amain)
[![Total Downloads](https://img.shields.io/packagist/dt/indracollective/laravel-revisor-filament.svg?style=flat-square)](https://packagist.org/packages/indracollective/laravel-revisor-filament)

Instantly add robust draft, versioning, and publishing functionality to your FilamentPHP admin panel with Revisor Filament.

This package builds on [Laravel Revisor](https://github.com/indracollective/laravel-revisor), offering a collection of Filament Actions, Table Columns, and Page components to seamlessly integrate Revisor with FilamentPHP, a popular admin panel for Laravel composed of beautiful full-stack components.

## Installation

```bash
composer require indracollective/laravel-revisor-filament
```

## Screenshots

![List Records](./docs/screenshots/list_records.png)

☝️ Table Actions / Bulk Actions for publishing and unpublishing records, viewing the revision history in Filament Tables.

![Edit Records](./docs/screenshots/edit_record.png)

☝️ Regular Actions for publishing and unpublishing records, viewing the revision history on Filament Edit pages.

![View Versions](./docs/screenshots/view_version_record.png)

☝️ View the version history of a record, and Revert to a previous versions of a record.

## Documentation

[laravel-revisor.indracollective.dev](https://laravel-revisor.indracollective.dev)

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
