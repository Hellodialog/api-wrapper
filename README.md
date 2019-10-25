# HelloDialog api-wrapper

[![Software License][ico-license]](LICENSE.md)

This is a php wrapper for connecting with the Hellodialog API V1

## Documentation

[You can find the complete API documentation (OpenAPI) here.](https://docs.hellodialog.dev "Documentation")

## Examples

We've made it easy for you. You can find all possible API calls in the directory: `/examples`

## Install

Via Composer

``` bash
$ composer require hellodialog/api-wrapper
```


## Configuration

Add your API credentials and email settings in `src/config/Hellodialog.php`


## Basic Usage

After installation and configuration, the `GlobalHandler` will be available to make calls to HelloDialog.

### Performing Calls

To manually perform calls, instantiate the `GlobalHandler` class.

```php
    $globalHandler = new GlobalHandler();
```

Available methods are listed in [GlobalHandler.php](https://github.com/Hellodialog/api-wrapper/blob/master/src/Handlers/GlobalHandler.php) and [`/src/Handlers`](https://github.com/Hellodialog/api-wrapper/tree/master/src/Handlers).


## Templates

Templates can be referred to by numerical ID, or the key set for their section in the config (which *must* have an `id` property set).


## Credits

- [Bart Ros][link-author]
- [Coen Zimmerman][link-org-author]


## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.


[ico-version]: https://img.shields.io/packagist/v/czim/hellodialog.svg?style=flat-square
[ico-license]: https://img.shields.io/badge/license-MIT-brightgreen.svg?style=flat-square
[ico-downloads]: https://img.shields.io/packagist/dt/czim/hellodialog.svg?style=flat-square

[link-packagist]: https://packagist.org/packages/czim/hellodialog
[link-downloads]: https://packagist.org/packages/czim/hellodialog
[link-org-author]: https://github.com/czim
[link-author]: https://github.com/BRdev
