[⬅️ to README.md](../README.md)
# Usage

+ [Usage with event loop](#ev)
+ [Usage without event loop](#no-ev)
+ [Patterns](#patterns)

## <a name="ev"></a> Usage with event loop - Asynchronous mode(default)

```php
use AlecRabbit\Spinner\Factory\Factory;

require_once __DIR__ . '/../bootstrap.php';

$spinner = Factory::createSpinner();
```
> see [example/async](../example/async)

## <a name="no-ev"></a> Usage without event loop - Synchronous mode

In synchronous mode usage is a bit more complicated. For the sake of examples `App::class` is used. It is a simple class with `run()` method. It is used to demonstrate how to use `Spinner` in synchronous mode.

```php
use Example\Kernel\App;

require_once __DIR__ . '/../bootstrap.php';

App::prepareDefaults();

$app = new App();

$app->run();
```
> see [example/synchronous](../example/synchronous)


## <a name="patterns"></a> Patterns

There are two pattern types:
- character patterns, e.g. `'⠏'` `'⠛'` `'⠹'`
- style patterns, describing which style to apply to a char frame

### Character patterns

List of supplied character patterns you will find [here](patterns.md).

#### How to create your own character pattern

For that purpose you can use `\AlecRabbit\Spinner\Core\Pattern\Char\CustomPattern::class`.

```php
// ...
$config =
    Facade::getConfigBuilder()
        ->withCharPattern(
            new CustomPattern(
                pattern: ['1', '2', '3'], // takes iterable of Stringable|string|IFrame
                interval: 1000, 
                reversed: false
            )
        )
        ->build();
// ...
```
> **Note** IFrame is a raw representation of a frame, e.g. `FrameFactory::create('⠹', 1)` 

### Style patterns

List of supplied style patterns you will find [here](patterns.md).

#### How to create your own style pattern

For that purpose you can use `\AlecRabbit\Spinner\Core\Pattern\Style\CustomStylePattern::class`.

```php
// ...
$config =
    Facade::getConfigBuilder()
        ->withStylePattern(
            new CustomStylePattern(
                pattern: [$style1, $style2], // required, takes iterable of IStyle|IFrame 
                colorMode: ColorMode::ANSI8  // optional
                interval: 1000,              // optional
                reversed: false              // optional
            )
        )
        ->build();
// ...
```
> **Note** IFrame is a raw representation of a frame, e.g. `FrameFactory::create("\e[38;2;255;255;255;48;2;255;0;0m%s\e[0m", 0)`(`%s` is important)

> **Note** AnsiColorConverter supplied with this package is capable of converting IStyle to ANSI escape codes using only foreground color, in `int` format or using `#rrggbb` format(only colors in a table). 

> **Note** IStyle|IFrame limitation is not implemented yet.
