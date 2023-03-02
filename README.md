<p align="center">
  <img alt="Logo" width="100" height="100" src="https://github.com/alecrabbit/php-console-spinner/raw/master/doc/image/logo/logo.png">
</p>

<p align="center">  
<b><i>Spinner - your task is running</i></b>
<br>
</p>

# 🇺🇦 🏵️ PHP Console Spinner

[![PHP Version](https://img.shields.io/packagist/php-v/alecrabbit/php-console-spinner.svg)](https://php.net)
[![Build Status](https://github.com/alecrabbit/php-console-spinner/workflows/build/badge.svg)](https://github.com/alecrabbit/php-console-spinner/actions)

[![Latest Stable Version](https://poser.pugx.org/alecrabbit/php-console-spinner/v/stable)](https://packagist.org/packages/alecrabbit/php-console-spinner)
[![Packagist Pre Release Version](https://img.shields.io/packagist/vpre/alecrabbit/php-console-spinner)](https://packagist.org/packages/alecrabbit/php-console-spinner)
[![Latest Unstable Version](https://poser.pugx.org/alecrabbit/php-console-spinner/v/unstable)](https://packagist.org/packages/alecrabbit/php-console-spinner)

[![License](https://poser.pugx.org/alecrabbit/php-console-spinner/license)](https://packagist.org/packages/alecrabbit/php-console-spinner)

### New version 1.0.0

> - WIP
> - ‼️ API is subject to change until `1.0.0-BETA.0`
> - is intended to be used with event loop (see [limitations](doc/limitations.md))

> Old version `0.55.0` is available in branch [0.55.x](https://github.com/alecrabbit/php-console-spinner/tree/0.55.x)

![demo](doc/image/demo/fpdemo.svg)

+ [Why?](#why)
+ [How does it work?](doc/how_does_it_work.md)
+ [Installation](#installation)
+ [Quick start](#quickstart)
+ [Usage](doc/usage.md)
+ [Features](#features)
+ [Known issues](doc/known_issues.md)
+ [Links](#links)

### <a name="why"></a>Why?

Main purpose of this library is to provide a simple way to show spinner in console applications.
Spinner could be an indicator of running task.
Also this library provides a way to show progress of running task and messages of some sort, like status messages.
For more information see [Features](doc/features.md) and [Examples](example).

### <a name="installation"></a> Installation

```bash
composer require alecrabbit/php-console-spinner
```

### <a name="quickstart"></a> Quick start (asynchronous)

```php
use AlecRabbit\Spinner\Factory;

$spinner = Factory::createSpinner();

// that's basically it :)
```

> Examples can be found in [example](example) directory

> For more information see [Usage](doc/usage.md)

### <a name="features"></a> Features

> See [Features](doc/features.md) and [limitations](doc/limitations.md) for more details

| Feature                 |                             | 
|-------------------------|:---------------------------:|
| Extremely flexible      |            🟢️ ️            |  
| Zero dependencies ️     | 🟢️ [*](doc/limitations.md) |
| Asynchronous            |            🟢️ ️            |
| Synchronous             |            🟢️ ️            |
| AutoStart (async)       |            🟢️ ️            |
| Signal handling (async) |            🟢️ ️            |
| Cursor auto hide/show   |            🟢️ ️            |


### <a name="links"></a> Links

- Inspired by [sindresorhus/cli-spinners](https://github.com/sindresorhus/cli-spinners)
