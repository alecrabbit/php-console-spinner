[⬅️ to README.md](../README.md)
# Usage

+ [Usage with event loop (Asynchronous mode)](#evl)
+ [Usage without event loop (Synchronous mode)](#no-evl)
+ [Custom palettes](#palettes)

## <a name="evl"></a> Usage with event loop - Asynchronous mode(default)

```php
use AlecRabbit\Spinner\Factory\Factory;

require_once __DIR__ . '/../bootstrap.php';

$spinner = Factory::createSpinner();
```

## <a name="no-evl"></a> Usage without event loop - Synchronous mode

In synchronous mode usage is a bit more complicated. Simply speaking, you need to periodically call `render()` method of `IDriver` implementation.

```php
$driver = \AlecRabbit\Spinner\Facade::getDriver();

while (true) {
    $driver->render();
    usleep(100000);
}
```

## <a name="palettes"></a> Custom palettes

There are four palettes supplied with the package: 
- Rainbow (style)
- NoStylePalette
- Snake (characters)
- NoCharPalette

#### How to create your own character palette

// todo

#### How to create your own style palette

// todo
