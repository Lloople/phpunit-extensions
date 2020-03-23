# PHPUnit Extensions

[![Latest Version on Packagist](https://img.shields.io/packagist/v/lloople/phpunit-extensions.svg?style=flat-square)](https://packagist.org/packages/lloople/phpunit-extensions)
[![Build Status](https://img.shields.io/travis/lloople/phpunit-extensions/master.svg?style=flat-square)](https://travis-ci.org/lloople/phpunit-extensions)
[![Quality Score](https://img.shields.io/scrutinizer/g/lloople/phpunit-extensions.svg?style=flat-square)](https://scrutinizer-ci.com/g/lloople/phpunit-extensions)
[![Total Downloads](https://img.shields.io/packagist/dt/lloople/phpunit-extensions.svg?style=flat-square)](https://packagist.org/packages/lloople/phpunit-extensions)
[![Buy us a tree](https://img.shields.io/badge/Buy%20James%20a%20tree-🌳-lightgreen)](https://plant.treeware.earth/Lloople/phpunit-extensions)

This package provides you a few useful extensions for your testsuite in an effort to improve your code.

## Installation

You can install the package via composer:

```bash
composer require lloople/phpunit-extensions --dev
```

Add the Extension to your `phpunit.xml` file:

```xml
<extensions>
    <extension class="Lloople\PHPUnitExtensions\Runners\SlowestTests\Console" />
</extensions>
```

## Extensions

### Console

Output the slowest tests on the console.

```xml
<extension class="Lloople\PHPUnitExtensions\Runners\SlowestTests\Console"/>
```

```
Showing the top 5 slowest tests:
  543 ms: Tests\Feature\ProfileTest::can_upload_new_profile_image
   26 ms: Tests\Feature\ProfileTest::can_visit_profile_page
   25 ms: Tests\Feature\ProfileTest::throws_validation_error_if_password_not_match
```

Default options are:

- rows: `5` (Report 5 tests max)
- min: `200` (Report tests slower than 200ms)

### Csv

Write the tests in a CSV file ready for import.

```xml
<extension class="Lloople\PHPUnitExtensions\Runners\SlowestTests\Csv"/>
```

Default options are:

- file: `phpunit_results.csv`
- rows: `null` (all the tests)
- min: `200`

### Json

Write the tests in a JSON file ready for import.

```xml
<extension class="Lloople\PHPUnitExtensions\Runners\SlowestTests\Json"/>
```

Default options are:

- file: `phpunit_results.json`
- rows: `null` (all the tests)
- min: `200`

### MySQL

Store the test name and the time into a MySQL database. It will override existing records

```xml
<extension class="Lloople\PHPUnitExtensions\Runners\SlowestTests\MySQL"/>
```

Default credentials are (as array):

- database: `phpunit_results`
- table: `default`
- username: `root`
- password: ``
- host: `127.0.0.1`
- rows: `null` (all the tests)
- min: `200`

### SQLite

Store the test name and the time into a SQLite database. It will override existing records

```xml
<extension class="Lloople\PHPUnitExtensions\Runners\SlowestTests\SQLite"/>
```

Default credentials are (as array):

- database: `phpunit_results.db`
- table: `default`
- rows: `null` (all the tests)
- min: `200`

## Arguments

To override the default configuration per extension, you need to use `<arguments>`in your `phpunit.xml` file

```xml
<extension class="Lloople\PHPUnitExtensions\Runners\SlowestTests\Json">
  <arguments>
    <string>phpunit_results_as_json.json</string>
    <integer>10</integer> <!-- Max number of tests to report. -->
    <integer>400</integer> <!-- Min miliseconds to report a test. -->
  </arguments>
</extension>
```

In the case of the MySQL and SQLite, which needs a database connection, configuration goes as array

```xml
<extension class="Lloople\PHPUnitExtensions\Runners\SlowestTests\MySQL">
  <arguments>
    <array>
      <element key="database">
        <string>my_phpunit_results</string>
      </element>
      <element key="table">
        <string>project1_test_results</string>
      </element>
      <element key="username">
        <string>homestead</string>
      </element>
      <element key="password">
        <string>secret</string>
      </element>
      <element key="host">
        <string>192.168.12.14</string>
      </element>
    </array>
  </arguments>
</extension>
```

You don't need to override those credentials that already fit to your 
usecase, since the class will merge your configuration with the default one

## Changelog

Please see [CHANGELOG](CHANGELOG.md) for more information what has changed recently.

## Contributing

Please see [CONTRIBUTING](CONTRIBUTING.md) for details.

## Security

If you discover any security related issues, please email d.lloople@icloud.com instead of using the issue tracker.

## Credits

- [David Llop](https://github.com/lloople)
- [All Contributors](../../contributors)

## Treeware

You're free to use this package, but if it is really useful for you I would highly appreciate you [buying the world a tree](https://plant.treeware.earth/Lloople/phpunit-extensions).

It’s now common knowledge that one of the best tools to tackle the climate crisis and keep our temperatures from rising above 1.5C is to plant trees. If you contribute to [Treeware](https://plant.treeware.earth/Lloople/phpunit-extensions)'s forest you’ll be creating employment for local families and restoring wildlife habitats.

You can buy trees here [offset.earth/treeware](https://plant.treeware.earth/Lloople/phpunit-extensions)

Read more about Treeware at [treeware.earth](http://treeware.earth)

