

<p align="center">
  <img alt="Logo" width="100" height="100" src="https://github.com/alecrabbit/php-console-spinner/raw/master/docs/images/ro37AC_sm.png">
</p>
 
<p align="center">  
Spinner - your task is running
</p>

#  🏵️  PHP Console Spinner

[![PHP Version](https://img.shields.io/packagist/php-v/alecrabbit/php-console-spinner.svg)](https://php.net/)
[![Build Status](https://travis-ci.com/alecrabbit/php-console-spinner.svg?branch=master)](https://travis-ci.com/alecrabbit/php-console-spinner)
[![Appveyor Status](https://img.shields.io/appveyor/ci/alecrabbit/php-console-spinner.svg?label=appveyor)](https://ci.appveyor.com/project/alecrabbit/php-console-spinner/branch/master)
[![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/alecrabbit/php-console-spinner/badges/quality-score.png?b=master)](https://scrutinizer-ci.com/g/alecrabbit/php-console-spinner/?branch=master)
[![Code Coverage](https://scrutinizer-ci.com/g/alecrabbit/php-console-spinner/badges/coverage.png?b=master)](https://scrutinizer-ci.com/g/alecrabbit/php-console-spinner/?branch=master)
[![Total Downloads](https://poser.pugx.org/alecrabbit/php-console-spinner/downloads)](https://packagist.org/packages/alecrabbit/php-console-spinner)

[![Latest Stable Version](https://poser.pugx.org/alecrabbit/php-console-spinner/v/stable)](https://packagist.org/packages/alecrabbit/php-console-spinner)
![Packagist Pre Release Version](https://img.shields.io/packagist/vpre/alecrabbit/php-console-spinner)
[![Latest Unstable Version](https://poser.pugx.org/alecrabbit/php-console-spinner/v/unstable)](https://packagist.org/packages/alecrabbit/php-console-spinner)

[![License](https://poser.pugx.org/alecrabbit/php-console-spinner/license)](https://packagist.org/packages/alecrabbit/php-console-spinner)
[![Average time to resolve an issue](http://isitmaintained.com/badge/resolution/alecrabbit/php-console-spinner.svg)](http://isitmaintained.com/project/alecrabbit/php-console-spinner "Average time to resolve an issue")
[![Percentage of issues still open](http://isitmaintained.com/badge/open/alecrabbit/php-console-spinner.svg)](http://isitmaintained.com/project/alecrabbit/php-console-spinner "Percentage of issues still open")


![advanced](docs/images/fpdemo.svg)

### ⚠️ Compatibility issues

> Update 2019-Nov-01: As of version `0.53` compatibility issues should be resolved, but it needs to be tested.

This project is still in its active development phase. It turned out that some of its indirect dependencies are causing compatibility issues. New release is expected to be ready in mid-november 2019. For now, as a solution, you can use lightweight spinner [alecrabbit/php-cli-snake](https://github.com/alecrabbit/php-cli-snake).

### Feature comparision

| Feature       | [php-console-spinner](https://github.com/alecrabbit/php-console-spinner)    |  [php-cli-snake](https://github.com/alecrabbit/php-cli-snake) |
| ------------- | :---:  | :---: |
| Lightweight        |  ❌ ️ |  ✔️  |
| Has zero dependencies      |  ❌ ️ |  ✔️  |
| Highly  configurable        |  ✔️ ️ |  ❌  |
| Contains various spinner classes        |  ✔️ ️ |  ❌  |
| Progress indicator        |  ✔️ ️ |  ❌  |
| Messages indicator        |  ✔️ ️ |  ❌  |
| Color settings for spinner       |  ✔️ ️ |  ❌  |
| Color settings for messages        |  ✔️ ️ |  ❌  |
| Color settings for progress indicator        |  ✔️ ️ |  ❌  |
| Has `disable()` method        |  ✔️ ️ |  ❌  |
| Has `enable()` method        |  ✔️ ️ |  ❌  |
| Can show final message      |  ✔️ ️ |  ❌  |
| Cursor hide can be disabled      |  ✔️ ️ |  ❌  |
| Can use optional custom output      |  ✔️ ️ |  ❌  |
| Has `erase()` method        |  ✔️ ️ |  ✔️ ️ |
| Hides cursor with `$spinner->begin()`  |  ✔️ ️ |  ✔️ ️ |
| Shows cursor with `$spinner->end()`  |  ✔️ ️ |  ✔️ ️ |
| Supports piping         |  ✔️ ️ |  ✔️ ️ |
| Supports redirect        |  ✔️ ️ |  ✔️ ️ |
| Supports `no color` mode        |  ✔️ ️ |  ✔️ ️ |
| Supports `16 color` mode        |  ✔️ ️ |  ✔️ ️ |
| Supports `256 color` mode        |  ✔️ ️ |  ✔️ ️ |

### Features
- progress indication during spin `$spinner->progress(0.5)` ➙ `50%`
- messages during spin `$spinner->message('message')`
- separated color settings for spinner, messages and progress indicator
- has `disable()` and `enable()` methods 
- hides cursor on `$spinner->begin()`, shows on `$spinner->end()`
- cursor hide can be disabled `$settings->setHideCursor(false)` 
- has `erase()` method
- final message `$spinner->end('final message')`
- supports unix pipe `|` and redirect `>` output
- supplied with `SymfonyOutputAdapter::class`

### Quickstart

#### Simple

> See [simple.php](examples/simple.php)

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
#### Advanced ([ReactPHP](https://github.com/reactphp))

> See [advanced.php](examples/advanced.php), [async.demo.php](examples/async.demo.php)

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
```

### Installation
```bash
composer require alecrabbit/php-console-spinner
 ```

### Usage
 - [Unix pipe and redirect](docs/pipe_redirect.md)
 - See [examples](https://github.com/alecrabbit/php-console-spinner/tree/master/examples)
 - Examples [output](docs/examples_output.md) casts

### Spinners
 
 [Here](docs/spinners.md) you can find a list of all spinners with demos 
 
### Operating Systems 

- Developed and tested on Ubuntu 18.04 (xterm terminal)

- On Windows it should work in any VT100 terminal, e.g. [minTTY](https://github.com/mintty/mintty).

### Links

 - Inspired by [sindresorhus/cli-spinners](https://github.com/sindresorhus/cli-spinners)
