<p align="center">
  <img alt="Logo" width="100" height="100" src="https://github.com/alecrabbit/php-console-spinner/raw/master/doc/image/logo/logo.png">
</p>

<p align="center">  
<b><i>Spinner - your task is running</i></b>
<br>
</p>

# 🇺🇦 🏵️ PHP Console Spinner

![demo](doc/image/demo/fpdemo.svg)

[![PHP Version](https://img.shields.io/packagist/php-v/alecrabbit/php-console-spinner/dev-master.svg)](https://php.net)
[![Tests Status](https://github.com/alecrabbit/php-console-spinner/workflows/tests/badge.svg)](https://github.com/alecrabbit/php-console-spinner/actions)

[![Build Status](https://scrutinizer-ci.com/g/alecrabbit/php-console-spinner/badges/build.png?b=master)](https://scrutinizer-ci.com/g/alecrabbit/php-console-spinner/build-status/master)
[![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/alecrabbit/php-console-spinner/badges/quality-score.png?b=master)](https://scrutinizer-ci.com/g/alecrabbit/php-console-spinner/?branch=master)
[![Code Coverage](https://scrutinizer-ci.com/g/alecrabbit/php-console-spinner/badges/coverage.png?b=master)](https://scrutinizer-ci.com/g/alecrabbit/php-console-spinner/?branch=master)

[![Latest Stable Version](https://poser.pugx.org/alecrabbit/php-console-spinner/v/stable)](https://packagist.org/packages/alecrabbit/php-console-spinner)
[![Packagist Pre Release Version](https://img.shields.io/packagist/vpre/alecrabbit/php-console-spinner)](https://packagist.org/packages/alecrabbit/php-console-spinner)
[![Latest Unstable Version](https://poser.pugx.org/alecrabbit/php-console-spinner/v/unstable)](https://packagist.org/packages/alecrabbit/php-console-spinner)

[![License](https://poser.pugx.org/alecrabbit/php-console-spinner/license)](https://packagist.org/packages/alecrabbit/php-console-spinner)

> Old version `0.55.0` is available in branch [0.55.x](https://github.com/alecrabbit/php-console-spinner/tree/0.55.x)

### New version 1.0.0

> - ‼️ ATTENTION ‼️ Documentation is a bit clumsy at the moment and CAN BE MISLEADING

> - WIP
> - ‼️ API is subject to change until `1.0.0-BETA.0`
> - is intended to be used with event loop (see [limitations](doc/limitations.md))



+ [Installation](#installation)
+ [Quick start](#quickstart)
+ [Why?](#why)
+ [How does it work?](doc/how_does_it_work.md)
+ [Usage](doc/usage.md)
+ [Features](#features)
+ [Known issues](doc/known_issues.md)
+ [Development](doc/development.md)
+ [Links](#links)

### <a name="installation"></a> Installation

```bash
composer require alecrabbit/php-console-spinner
```

### <a name="quickstart"></a> Quick start (asynchronous)

```php
use AlecRabbit\Spinner\Facade;
// ...
$spinner = Facade::createSpinner();

// that's basically it :)
```

> Fully working examples can be found in [example](example) directory

> For more information see [Usage](doc/usage.md)

### <a name="why"></a>Why?

Main purpose of this library is to provide a simple way to show spinner in console applications
(mainly long-running ones). Spinner could be an indicator of running task. For more information 
see [Features](doc/features.md) and [Examples](example).

[alecrabbit/php-console-spinner-extras](https://github.com/alecrabbit/php-console-spinner-extras) 
library provides additional components to extend functionality:
 - show progress of running task 
 - messages of some sort, like status messages
 - additional spinners

### <a name="features"></a> Features

> See [Features](doc/features.md) and [limitations](./doc/limitations.md) for more details

| Feature                |                             | 
|------------------------|:---------------------------:|
| Extremely flexible     |            🟢️ ️            |  
| "Zero" dependencies ️    | 🟢️ [*](doc/limitations.md) |
| Asynchronous           |            🟢️ ️            |
| Synchronous            |            🟢️ ️            |
| AutoStart (async)      |            🟢️ ️            |
| Signal handling (async) |            🟢️ ️            |
| Cursor auto hide/show  |            🟢️ ️            |

### "Zero" dependencies

"Zero" dependencies mode means that the library does not require any additional dependencies to work. The only exception
is `psr/container`. That's why zero is in quotes.
```json
    "require": {
        "php": ">=8.2",
        "psr/container": "^2.0"
    },
```

### <a name="links"></a> Links

- Inspired by [sindresorhus/cli-spinners](https://github.com/sindresorhus/cli-spinners)
