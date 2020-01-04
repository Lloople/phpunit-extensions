# PHPUnit Extensions

[![Latest Version on Packagist](https://img.shields.io/packagist/v/lloople/phpunit-extensions.svg?style=flat-square)](https://packagist.org/packages/lloople/phpunit-extensions)
[![Build Status](https://img.shields.io/travis/lloople/phpunit-extensions/master.svg?style=flat-square)](https://travis-ci.org/lloople/phpunit-extensions)
[![Quality Score](https://img.shields.io/scrutinizer/g/lloople/phpunit-extensions.svg?style=flat-square)](https://scrutinizer-ci.com/g/lloople/phpunit-extensions)
[![Total Downloads](https://img.shields.io/packagist/dt/lloople/phpunit-extensions.svg?style=flat-square)](https://packagist.org/packages/lloople/phpunit-extensions)

This package provides you a few useful extensions for your testsuite in an effort to improve your code.

## Installation

You can install the package via composer:

```bash
composer require lloople/phpunit-extensions --dev
```

Add the Extension to your `phpunit.xml` file:

```xml
<extensions>
    <extension class="Lloople\PHPUnitExtensions\Runners\MySQL">
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

## Extensions

### MySQL

Store the test name and the time into a MySQL database. It will override existing records

```xml
<extension class="Lloople\PHPUnitExtensions\Runners\MySQL"/>
```

Default credentials are (as array):

- database: `phpunit_results`
- table: `default`
- username: `root`
- password: ``
- host: `127.0.0.1`

### SQLite

Store the test name and the time into a SQLite database. It will override existing records

```xml
<extension class="Lloople\PHPUnitExtensions\Runners\SQLite"/>
```

Default credentials are (as array):

- database: `phpunit_results.db`
- table: `default`

## Console

Output the slowest tests on the console.

```xml
<extension class="Lloople\PHPUnitExtensions\Runners\Console"/>
```

```
Showing the top 5 slowest tests:
  543 ms: Tests\Feature\ProfileTest::can_upload_new_profile_image
   26 ms: Tests\Feature\ProfileTest::can_visit_profile_page
   25 ms: Tests\Feature\ProfileTest::throws_validation_error_if_password_not_match
```

Default options are:

- rows: `5`

### Testing

> Under development

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