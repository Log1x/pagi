# Pagi

![Latest Stable Version](https://img.shields.io/packagist/v/log1x/pagi?style=flat-square)
![Total Downloads](https://img.shields.io/packagist/dt/log1x/pagi?style=flat-square)
![Build Status](https://img.shields.io/github/workflow/status/log1x/pagi/compatibility?style=flat-square)

A better WordPress pagination utilizing [Laravel's Pagination](https://laravel.com/docs/master/pagination).

## Requirements

- [Sage](https://github.com/roots/sage) >= 10.0
- [PHP](https://secure.php.net/manual/en/install.php) >= 7.3
- [Composer](https://getcomposer.org/download/)

## Installation

Install via Composer:

```bash
$ composer require log1x/pagi
```

## Usage

### Basic Usage

```php
use Log1x\Pagi\PagiFacade as Pagi;

$pagination = Pagi::build();

return $pagination->links();
```

### Customization

To customize the view, simply publish it:

```bash
$ wp acorn vendor:publish --provider='Log1x\Pagi\PagiServiceProvider'
```

To use the newly generated view:

```php
return $pagination->links('components.pagination');
```

For additional configuration, check out the [Laravel Pagination](https://laravel.com/docs/master/pagination) documentation.

## Bug Reports

If you discover a bug in Pagi, please [open an issue](https://github.com/log1x/pagi/issues).

## Contributing

Contributing whether it be through PRs, reporting an issue, or suggesting an idea is encouraged and appreciated.

## License

Pagi is provided under the [MIT License](https://github.com/log1x/pagi/blob/master/LICENSE.md).
