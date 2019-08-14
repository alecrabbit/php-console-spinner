# php-console-spinner
Spinner - your task is running

[![PHP Version](https://img.shields.io/packagist/php-v/alecrabbit/php-console-spinner.svg)](https://php.net/)
[![Build Status](https://travis-ci.com/alecrabbit/php-console-spinner.svg?branch=master)](https://travis-ci.com/alecrabbit/php-console-spinner)
[![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/alecrabbit/php-console-spinner/badges/quality-score.png?b=master)](https://scrutinizer-ci.com/g/alecrabbit/php-console-spinner/?branch=master)
[![Code Coverage](https://scrutinizer-ci.com/g/alecrabbit/php-console-spinner/badges/coverage.png?b=master)](https://scrutinizer-ci.com/g/alecrabbit/php-console-spinner/?branch=master)
[![Total Downloads](https://poser.pugx.org/alecrabbit/php-console-spinner/downloads)](https://packagist.org/packages/alecrabbit/php-console-spinner)

[![Latest Stable Version](https://poser.pugx.org/alecrabbit/php-console-spinner/v/stable)](https://packagist.org/packages/alecrabbit/php-console-spinner)
[![Latest Version](https://img.shields.io/packagist/v/alecrabbit/php-console-spinner.svg)](https://packagist.org/packages/alecrabbit/php-console-spinner)
[![Latest Unstable Version](https://poser.pugx.org/alecrabbit/php-console-spinner/v/unstable)](https://packagist.org/packages/alecrabbit/php-console-spinner)

[![License](https://poser.pugx.org/alecrabbit/php-console-spinner/license)](https://packagist.org/packages/alecrabbit/php-console-spinner)
[![Average time to resolve an issue](http://isitmaintained.com/badge/resolution/alecrabbit/php-console-spinner.svg)](http://isitmaintained.com/project/alecrabbit/php-console-spinner "Average time to resolve an issue")
[![Percentage of issues still open](http://isitmaintained.com/badge/open/alecrabbit/php-console-spinner.svg)](http://isitmaintained.com/project/alecrabbit/php-console-spinner "Percentage of issues still open")


![demo](docs/images/demo.svg)

![advanced](docs/images/advanced.svg)

### Quickstart

#### Simple

```php
require_once __DIR__ . '/vendor/autoload.php';

use AlecRabbit\Spinner\SnakeSpinner;

const ITERATIONS = 50;

$spinner = new SnakeSpinner();

$spinner->begin();
for ($i = 0; $i <= ITERATIONS; $i++) {
    usleep(80000); // Simulating work
    $spinner->spin();
}
$spinner->end();
```
#### Using ReactPHP(async)

```php
require_once __DIR__ . '/../vendor/autoload.php';

use AlecRabbit\Spinner\BlockSpinner;
use React\EventLoop\Factory;

$s = new BlockSpinner();

$loop = Factory::create();

$loop->addPeriodicTimer($s->interval(), static function () use ($s) {
    $s->spin();
});

$s->begin();

$loop->run();

$s->end();
```

### Installation
```bash
composer require alecrabbit/php-console-spinner
 ```

### Usage
See [examples](https://github.com/alecrabbit/php-console-spinner/tree/master/examples)

Examples [output](docs/examples_output.md)
