<p align="center">
  <img alt="Logo" width="100" height="100" src="https://github.com/alecrabbit/php-console-spinner/raw/master/doc/image/logo/logo.png">
</p>
 
<p align="center">  
<b><i>Spinner - your task is running</i></b>
<br>
</p>

# 🇺🇦 🏵️  PHP Console Spinner 

[![PHP Version](https://img.shields.io/packagist/php-v/alecrabbit/php-console-spinner.svg)](https://php.net)
[![License](https://poser.pugx.org/alecrabbit/php-console-spinner/license)](https://packagist.org/packages/alecrabbit/php-console-spinner)

### New version 1.0.0

> - WIP
> - ❗ API is subject to change until `1.0.0-BETA.0`
> - is intended to be used with event loop (see [limitations](doc/limitations.md))

![demo](doc/image/demo/fpdemo.svg)

+ [Why?](#why)
+ [How does it work?](doc/how_does_it_work.md)
+ [Installation](#installation)
+ [Quick start](#quickstart)
+ [Usage](doc/usage.md)
+ [Features](#features)
+ [Known issues](doc/known_issues.md)
+ [Links](#links)

###  <a name="why"></a>Why?
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
> See [Features](doc/features.md) for more details

| Feature               | [php-console-spinner](https://github.com/alecrabbit/php-console-spinner) | [php-cli-snake](https://github.com/alecrabbit/php-cli-snake) |
|-----------------------|:------------------------------------------------------------------------:|:------------------------------------------------------------:|
| Lightweight           |                                   ❌ ️                                    |                             🟢️                              |
| Has zero dependencies |                                  🟢* ️                                   |                             🟢️                              |
| Extremely flexible    |                                  🟢️ ️                                   |                              ❌                               |

> - `❌` - No
> - `🟢️` - Yes
> - `🟢️️*` - Yes, see [limitations](doc/limitations.md)

### <a name="links"></a> Links

 - Inspired by [sindresorhus/cli-spinners](https://github.com/sindresorhus/cli-spinners)
