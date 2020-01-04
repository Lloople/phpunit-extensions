# PHPUnit Extensions

[![Latest Version on Packagist](https://img.shields.io/packagist/v/lloople/phpunit-extensions.svg?style=flat-square)](https://packagist.org/packages/lloople/phpunit-extensions)
[![Build Status](https://img.shields.io/travis/lloople/phpunit-extensions/master.svg?style=flat-square)](https://travis-ci.org/lloople/phpunit-extensions)
[![Quality Score](https://img.shields.io/scrutinizer/g/lloople/phpunit-extensions.svg?style=flat-square)](https://scrutinizer-ci.com/g/lloople/phpunit-extensions)
[![Total Downloads](https://img.shields.io/packagist/dt/lloople/phpunit-extensions.svg?style=flat-square)](https://packagist.org/packages/lloople/phpunit-extensions)

This is where your description should go. Try and limit it to a paragraph or two, and maybe throw in a mention of what PSRs you support to avoid any confusion with users and contributors.

## Installation

You can install the package via composer:

```bash
composer require lloople/phpunit-extensions
```

Add the Extension to your `phpunit.xml` file:

```xml
<extensions>
    <extension class="Lloople\PHPUnitExtensions\Log\MySQL">
        <arguments>
            <array>
                <element key="table">
                    <string>my_project</string>
                </element>
            </array>
        </arguments>
    </extension>
</extensions>
```

### Testing

``` bash
composer test
```

### Changelog

Please see [CHANGELOG](CHANGELOG.md) for more information what has changed recently.

## Contributing

Please see [CONTRIBUTING](CONTRIBUTING.md) for details.

### Security

If you discover any security related issues, please email d.lloople@icloud.com instead of using the issue tracker.

## Credits

- [David Llop](https://github.com/lloople)
- [All Contributors](../../contributors)

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.