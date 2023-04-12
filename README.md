
<p align="center"><img src="https://static.typeset.sh/images/typeset.sh-logo.svg" width="300"></p>


# Typeset.sh wrapper for Laravel 7, 8, 9 and 10

This is a laravel typeset.sh wrapper that lets you easily configure and use typeset.sh
in your laravel project. Typeset.sh is a printcss layout and rendering engine written in PHP.


## Installation

Make sure you have access to a valid composer token from typeset.sh.

Add typeset.sh package repository to composer and install the package via composer:

    composer config repositories.typesetsh composer https://packages.typeset.sh
    composer require typesetsh/laravel-wrapper

The package will be automatically discovered in your application thanks to [package auto-discovery](https://laravel.com/docs/8.x/packages#package-discovery).

## Usage

The wrapper works similar to the view. Technically it wraps the view and uses its html output
and renders it as pdf.

### Facade

You can use the facade pattern. Similar as you would render a view.

```php
use Typesetsh\LaravelWrapper\Facades\Pdf;

Route::get('/invoice/print', function () {
    $invoice = new stdClass();
    
    return Pdf::make('invoice', ['invoice' => $invoice]);
});
```


### Helper

Alternative you can use the helper.

```php

Route::get('/invoice/print', function () {
    $invoice = new stdClass();
    
    return Typesetsh\pdf('invoice', ['invoice' => $invoice]);
});
```

or force a download

```php

Route::get('/invoice/print', function () {
    $invoice = new stdClass();
    
    return Typesetsh\pdf('invoice', ['invoice' => $invoice])->forceDownload('invoice.pdf');
});
```


## Configuration

Typeset.sh does not require much configuration. The only important aspect to understand is that
by default typeset.sh does not allow including any external resources (image, css, fonts,...) 
unless specified.

See the configuration file `config/typesetsh.php` for more information. By default, typeset.sh
has access to the public directory and any http(s) resources.

You can also publish the file using:

    php artisan vendor:publish --provider="Typesetsh\LaravelWrapper\ServiceProvider"
    
    
## License

This extension is under the [MIT license](LICENSE).

However, it requires a version of [typeset.sh](https://typeset.sh/) to work.
