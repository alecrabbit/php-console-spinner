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
> see [examples/async](../example/async)

## <a name="no-ev"></a> Usage without event loop - Synchronous mode

In synchronous mode usage is a bit more complicated. For tha sake of examples `App::class` is used. It is a simple class with `run()` method. It is used to demonstrate how to use `Spinner` in synchronous mode.

```php
use Example\Kernel\App;

require_once __DIR__ . '/../bootstrap.php';

App::prepareDefaults();

$app = new App();

$app->run();
```
> see [examples/synchronous](../example/synchronous)


## <a name="patterns"></a> Patterns

There are two pattern types:
    - character patterns, e.g. `'⠏'` `'⠛'` `'⠹'`
    - style patterns, describing which style to apply to a frame in a sequence

### Character patterns

List of supplied character patterns you will find [here]().

#### How to create your own character pattern

For that purpose you can use `\AlecRabbit\Spinner\Core\Pattern\Char\Custom::class`.

```php
// ...
$config =
    Facade::getConfigBuilder()
        ->withCharPattern(
            new Custom(
                pattern: ['1', '2', '3'], // takes iterable of string|IFrame
                interval: 100, 
                reversed: true
            )
        )
        ->build();
// ...
```

### Style patterns
