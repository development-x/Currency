
| Sensiolab Insight | Travis-CI | Scrutinizer |
| --- | --- | --- |
| [![SensioLabsInsight](https://insight.sensiolabs.com/projects/2637edbc-6b80-43b9-a524-2061649ff5d1/mini.png)](https://insight.sensiolabs.com/projects/2637edbc-6b80-43b9-a524-2061649ff5d1) | [![Build Status](https://travis-ci.org/development-x/Currency.svg?branch=master)](https://travis-ci.org/development-x/Currency) | [![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/development-x/Currency/badges/quality-score.png?b=master)](https://scrutinizer-ci.com/g/development-x/Currency/?branch=master) [![Code Coverage](https://scrutinizer-ci.com/g/development-x/Currency/badges/coverage.png?b=master)](https://scrutinizer-ci.com/g/development-x/Currency/?branch=master) [![Build Status](https://scrutinizer-ci.com/g/development-x/Currency/badges/build.png?b=master)](https://scrutinizer-ci.com/g/development-x/Currency/build-status/master) |

| Packagist |
| --- |
| [![Packagist](https://img.shields.io/packagist/dt/development-x/Currency.svg)](https://github.com/development-x/Currency) [![Packagist](https://img.shields.io/packagist/l/development-x/Currency.svg)](https://github.com/development-x/Currency) [![Packagist Pre Release](https://img.shields.io/packagist/vpre/development-x/Currency.svg)](https://github.com/development-x/Currency) [![Packagist Pre Release](https://img.shields.io/hhvm/development-x/Currency.svg)](https://github.com/development-x/Currency) |


## Currency class
Basic currency features - convert amount to words

## Requirements
------------

 * PHP 5.5+

## Installation
------------
Install with [Composer](http://packagist.org), run:

```sh
composer require development-x/media-service-provider
```

## Use it
```php
<?php

echo Currency::convertAmountToText(1.23, Currency::LANG_BG);
echo Currency::convertAmountToText(1.23, Currency::LANG_EN);

```

## ToDo
- [ ] Add more functionality
- [ ] Add more unit tests

## Contributing
However, if you are interested and want to send a bug fix, new functionality or better realization, just send a pull request .
