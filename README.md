# HelloDialog api-wrapper

[![Software License][ico-license]](LICENSE.md)

This is a php wrapper for connecting with the Hellodialog API V1




## Install

Via Composer

``` bash
$ composer require hellodialog/api-wrapper
```

Then add the service provider in `config/app.php`:

    Hellodialog\ApiWrapper\HelloDialogServiceProvider::class,

Finally publish the config using the artisan command:

```bash
$ php artisan vendor:publish
```

## Configuration

Set the configuration in `config/hellodialog.php`.


## Basic Usage

After installation and configuration, the `HelloDialogHandler` will be available to make custom calls to HelloDialog. The `hellodialog` mail driver is also available.

### The Mail Driver

See the `hellodialog.php` config file for further details about configuring and using the mail driver.
Note that you cannot use all mail properties using this driver (BCC does not work, for instance). 
As always with HelloDialog, sending to multiple addresses will result in multiple calls to the HelloDialog API and will be mailed separately. 

When using the mail driver, a transactional template is expected with at least a 'content' replace, and optionally a 'title' replace. The placeholder for these may be set in the config (defaults to `__CONTENT__`). The entire mail view contents will be used as the 'content' replace value.

### Performing Calls

To manually perform calls, instantiate the `HelloDialogHandler` class.

```php
    $handler = app(\Hellodialog\ApiWrapper\Contracts\HelloDialogHandlerInterface::class);
    // or:
    $handler = new \Hellodialog\ApiWrapper\HelloDialogHandler();
```

Available methods are listed [in the HelloDialogHandlerInterface](https://github.com/czim/hellodialog/blob/master/src/Contracts/HelloDialogHandlerInterface.php).


## Templates

Templates can be referred to by numerical ID, or the key set for their section in the config (which *must* have an `id` property set).

## Logging

By default, any logging will be done using Laravel's `Log` facade.
Alternatively, you may pass in a custom Monolog logger (anything that implements `Psr\Log\LoggerInterface`) when instantiating the `HelloDialogHandler`.


## Contributing

Please see [CONTRIBUTING](CONTRIBUTING.md) for details.


## Credits

- [Coen Zimmerman][link-author]
- [All Contributors][link-contributors]

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.

[ico-version]: https://img.shields.io/packagist/v/czim/hellodialog.svg?style=flat-square
[ico-license]: https://img.shields.io/badge/license-MIT-brightgreen.svg?style=flat-square
[ico-downloads]: https://img.shields.io/packagist/dt/czim/hellodialog.svg?style=flat-square

[link-packagist]: https://packagist.org/packages/czim/hellodialog
[link-downloads]: https://packagist.org/packages/czim/hellodialog
[link-author]: https://github.com/czim
[link-contributors]: ../../contributors
