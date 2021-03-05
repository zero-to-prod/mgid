# An expressive and fluent package that interfaces with the MGID REST api.

[![Latest Version on Packagist](https://img.shields.io/packagist/v/zerotoprod/mgid.svg?style=flat-square)](https://packagist.org/packages/zerotoprod/mgid)
[![GitHub Tests Action Status](https://img.shields.io/github/workflow/status/zerotoprod/mgid/Tests?label=tests)](https://github.com/zerotoprod/mgid/actions?query=workflow%3ATests+branch%3Amaster)
[![Total Downloads](https://img.shields.io/packagist/dt/zerotoprod/mgid.svg?style=flat-square)](https://packagist.org/packages/zerotoprod/mgid)


Have access to the MGID REST api via a php package.


## Installation

You can install the package via composer:

```bash
composer require zerotoprod/mgid
```

## Usage

```php
$skeleton = new Zerotoprod\Mgid();
echo $skeleton->echoPhrase('Hello, Zerotoprod!');
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

- [David Smith](https://github.com/zero-to-prod)
- [All Contributors](../../contributors)

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.
