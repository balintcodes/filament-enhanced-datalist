# An enhanced version of text input with datalist for FilamentPHP

[![Latest Version on Packagist](https://img.shields.io/packagist/v/balintcodes/filament-enhanced-datalist.svg?style=flat-square)](https://packagist.org/packages/balintcodes/filament-enhanced-datalist)
[![GitHub Tests Action Status](https://img.shields.io/github/actions/workflow/status/balintcodes/filament-enhanced-datalist/run-tests.yml?branch=main&label=tests&style=flat-square)](https://github.com/balintcodes/filament-enhanced-datalist/actions?query=workflow%3Arun-tests+branch%3Amain)
[![GitHub Code Style Action Status](https://img.shields.io/github/actions/workflow/status/balintcodes/filament-enhanced-datalist/fix-php-code-styling.yml?branch=main&label=code%20style&style=flat-square)](https://github.com/balintcodes/filament-enhanced-datalist/actions?query=workflow%3A"Fix+PHP+code+styling"+branch%3Amain)
[![Total Downloads](https://img.shields.io/packagist/dt/balintcodes/filament-enhanced-datalist.svg?style=flat-square)](https://packagist.org/packages/balintcodes/filament-enhanced-datalist)

An implementation of text input fields with datalist that matches the looks of the FilamentPHP ecosystem.

## Installation

You can install the package via composer:

```bash
composer require balintcodes/filament-enhanced-datalist
```

## Usage

```php
include Balintcodes\FilamentEnhancedDatalist;

FilamentEnhancedDatalist::make('enhanced_datalist')
    ->options(['One', 'Two', 'Three'])  // Options that should appear in the datalist
    ->filterDatalist()                  // Whether the datalist should be filtered during typing
    ->chevronVisible()                  // Whether the dropdown chevron should be visible
    ->infoLabel('Select a number')      // Customize the information label on the top of the datalist
    ->label('Enhanced datalist')        
    ->minLength(2)
    ->maxLength(16)
    ->readOnly()
    ->prefix('Prefix')
    ->postfix('Postfix')
    ->placeholder('Choose a number');
```

## Changelog

Please see [CHANGELOG](CHANGELOG.md) for more information on what has changed recently.

## Contributing

Please see [CONTRIBUTING](.github/CONTRIBUTING.md) for details.

## Security Vulnerabilities

Please review [our security policy](../../security/policy) on how to report security vulnerabilities.

## Credits

- [Bálint Nagy](https://github.com/balintcodes)
- [All Contributors](../../contributors)

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.
