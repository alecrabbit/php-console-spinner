[⬅️ to README.md](../README.md)
# Usage

+ [Use cases](#usecases)
+ [Usage with event loop (Asynchronous mode)](#evl)
+ [Usage without event loop (Synchronous mode)](#no-evl)
+ [Custom palettes](#palettes)

## <a name="usecases"></a> Use cases

When to use spinners?
- You have a long-running process (e.g. searching for a specific hashtag) and you want to show that it is still running. 
- Your application is waiting for an event.

## <a name="evl"></a> Usage with event loop - Asynchronous mode(default)

```php
use AlecRabbit\Spinner\Facade;

$spinner = Facade::createSpinner();
```

## <a name="no-evl"></a> Usage without event loop - Synchronous mode

In synchronous mode usage is a bit more complicated. Simply speaking, you need to periodically call `render()` method of `IDriver` implementation.

```php
use AlecRabbit\Spinner\Facade;

$spinner = Facade::createSpinner();

$driver = Facade::getDriver();

while (true) {
    $driver->render();
    // do some work 
}
```

## <a name="palettes"></a> Custom palettes

There are four palettes supplied with the package: 
- Rainbow (style)
- Snake (characters)
- NoStylePalette
- NoCharPalette

#### How to create your own character palette

```php
class Dots extends ACharPalette {
    protected function createFrame(string $element, ?int $width = null): ICharFrame
    {
        return new CharFrame($element, $width ?? 3); // note the width is 3
    }

    /** @inheritDoc */
    protected function sequence(): Traversable
    {
        // note the width of each element
        yield from ['   ', '.  ', '.. ', '...', ' ..', '  .', '   ']; 
    }
}
```

#### How to create your own style palette

```php
class Greeny extends AStylePalette {
    protected function ansi4StyleFrames(): Traversable
    {
        yield from [
            $this->createFrame("\e[92m%s\e[39m"), // note the ANSI codes
        ];
    }

    protected function ansi8StyleFrames(): Traversable
    {
        return $this->ansi4StyleFrames();
    }

    protected function ansi24StyleFrames(): Traversable
    {
        return $this->ansi4StyleFrames();
    }
    
    protected function modeInterval(?IPaletteMode $mode = null): ?int
    {
        return null; // due to single style frame
    }
}
```
