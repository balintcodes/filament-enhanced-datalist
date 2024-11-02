# An enhanced version of text input with datalist for FilamentPHP

[![Latest Version on Packagist](https://img.shields.io/packagist/v/balintxd/filament-enhanced-datalist.svg?style=flat-square)](https://packagist.org/packages/balintxd/filament-enhanced-datalist)
[![GitHub Tests Action Status](https://img.shields.io/github/actions/workflow/status/balintxd/filament-enhanced-datalist/run-tests.yml?branch=main&label=tests&style=flat-square)](https://github.com/balintxd/filament-enhanced-datalist/actions?query=workflow%3Arun-tests+branch%3Amain)
[![GitHub Code Style Action Status](https://img.shields.io/github/actions/workflow/status/balintxd/filament-enhanced-datalist/fix-php-code-styling.yml?branch=main&label=code%20style&style=flat-square)](https://github.com/balintxd/filament-enhanced-datalist/actions?query=workflow%3A"Fix+PHP+code+styling"+branch%3Amain)
[![Total Downloads](https://img.shields.io/packagist/dt/balintxd/filament-enhanced-datalist.svg?style=flat-square)](https://packagist.org/packages/balintxd/filament-enhanced-datalist)



This is where your description should go. Limit it to a paragraph or two. Consider adding a small example.

## Installation

You can install the package via composer:

```bash
composer require balintxd/filament-enhanced-datalist
```

You can publish and run the migrations with:

```bash
php artisan vendor:publish --tag="filament-enhanced-datalist-migrations"
php artisan migrate
```

You can publish the config file with:

```bash
php artisan vendor:publish --tag="filament-enhanced-datalist-config"
```

Optionally, you can publish the views using

```bash
php artisan vendor:publish --tag="filament-enhanced-datalist-views"
```

This is the contents of the published config file:

```php
return [
];
```

## Usage

```php
$filamentEnhancedDatalist = new Balintxd\FilamentEnhancedDatalist();
echo $filamentEnhancedDatalist->echoPhrase('Hello, Balintxd!');
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

- [Bálint Nagy](https://github.com/balintxd)
- [All Contributors](../../contributors)

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.
