# Laravel Twig

[![Latest Version on Packagist](https://img.shields.io/packagist/v/dinhquochan/laravel-twig.svg?style=flat-square)](https://packagist.org/packages/dinhquochan/laravel-twig)
![tests](https://github.com/dinhquochan/laravel-twig/workflows/tests/badge.svg)
[![Total Downloads](https://img.shields.io/packagist/dt/dinhquochan/laravel-twig.svg?style=flat-square)](https://packagist.org/packages/dinhquochan/laravel-twig)

Allows you to use [Twig](https://twig.symfony.com/) in [Laravel](https://laravel.com/).

## Requirements

- PHP >= 7.3.0
- Laravel >= 6.x

## Installation

You can install the package via composer:

```bash
composer require dinhquochan/laravel-twig
```

If you don't use auto-discovery, add the Service Provider to the providers array in config/app.php

```php
\DinhQuocHan\Twig\TwigServiceProvider::class,
```

If you want to use the facade to extended twig extensions, add this to your facades in app.php:

```php
'Twig' => \DinhQuocHan\Twig\Facades\Twig::class,
```
So, we will use Artisan to add the new twig config file:

```
php artisan vendor:publish --provider="DinhQuocHan\Twig\TwigServiceProvider"
```

## Usage

You call the Twig template like you would any other view:

```php
// Normal (template.html.twig or template.css.twig or template.twig)
return view('template', ['some_variable' => 'some_values']);

// With vender namespace
return view('vendor_namespace::template', $data);
```

Read more in [Twig for Template Designers](https://twig.symfony.com/doc/2.x/templates.html) or [Laravel Views](https://laravel.com/docs/5.7/views).

### Extending Twig

Laravel Twig allows you to define your own custom filters, functions, globals, token parsers or extensions.

The following example creates a `{{ product.price|money_format }}` filter which formats a given `$product->price`:

```php
<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use DinhQuocHan\Twig\Facades\Twig;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register bindings in the container.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Twig::addFilter(new TwigFilter('money_format', function ($price) {
            return sprintf('%d %s', number_format($price), 'US$');
        }));
    }
}
```

**Available methods:**

- `Twig::addGlobal(string $name, $value)` Creating a global
- `Twig::addFilter(\Twig\TwigFilter $filter)` Creating a filter
- `Twig::addFunction(\Twig\TwigFunction $function)` Creating a function
- `Twig::addTest(\Twig\TwigTest $test)` Creating a test
- `Twig::addTokenParser(\Twig\TokenParser\TokenParserInterface $parser)` Creating a token parser
- `Twig::addExtension(\Twig\Extension\ExtensionInterface $extension)` Creating a extension

Read more in [Twig for Template Designers](https://twig.symfony.com/doc/2.x/advanced.html).

### Built-in Laravel Extensions

- `\DinhQuocHan\Twig\Extensions\Arr::class`
- `\DinhQuocHan\Twig\Extensions\Auth::class`
- `\DinhQuocHan\Twig\Extensions\Config::class`
- `\DinhQuocHan\Twig\Extensions\Dump::class`
- `\DinhQuocHan\Twig\Extensions\Gate::class`
- `\DinhQuocHan\Twig\Extensions\Path::class`
- `\DinhQuocHan\Twig\Extensions\Request::class`
- `\DinhQuocHan\Twig\Extensions\Session::class`
- `\DinhQuocHan\Twig\Extensions\Str::class`
- `\DinhQuocHan\Twig\Extensions\Translator::class`
- `\DinhQuocHan\Twig\Extensions\Url::class`

**Functions:**

- `array_*`, `data_*`, `head`, `last`
- `auth`, `auth_check`, `auth_guest`, `auth_user`, `auth_guard`
- `config`, `config_get`, `config_has`
- `dump`, `dd`
- `can`, `cant`, `cannot`, `allows`, `denies`
- `*_path`, `mix`
- `request`, `request_has`,  `request_exists`, `request_filled`, `request_input`,  `request_query`,  `request_is`,  `current_url`,  `current_full_url`,  `current_full_url_with_query`, `old`
- `session`, `session_has`, `session_get`, `session_put`, `session_pull`, `session_forget`, `csrf_token`, `csrf_field`, `method_field`
- `str_*` (All the `Str::*` methods, `snake_case`, `camel_case`, `studly_case`, `kebab_case`)
- `__`, `trans`, `trans_choice`
- `action`, `asset`, `url`, `route`, `secure_url`, `secure_asset`

**Filters:**

- `*_path`, `mix`
- `str_*` (All the `Str::*` methods, `snake_case`, `camel_case`, `studly_case`, `kebab_case`)
- `__`, `trans`, `trans_choice`
- `action`, `asset`, `url`, `route`, `secure_url`, `secure_asset`

**Global variables:**
- `app`: the `Illuminate\Foundation\Application::class` object

### Testing

```bash
composer test
```

### Changelog

Please see [CHANGELOG](CHANGELOG.md) for more information on what has changed recently.

## Contributing

Please see [CONTRIBUTING](CONTRIBUTING.md) for details.

### Security

If you discover any security related issues, please email contact@dinhquochan.com instead of using the issue tracker.

## Credits

- [Dinh Quoc Han](https://github.com/dinhquochan)
- [All Contributors](../../contributors)

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.
