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
    // do some work 
}
```

## <a name="palettes"></a> Custom palettes

There are four palettes supplied with the package: 
- Rainbow (style)
- NoStylePalette
- Snake (characters)
- NoCharPalette

#### How to create your own character palette

```php
class Dots extends ACharPalette {
    protected function createFrame(string $element): ICharFrame
    {
        return new CharFrame($element, 3); // note the width is 3
    }

    /** @inheritDoc */
    protected function sequence(): Traversable
    {
        // note the width of each element
        $a = ['   ', '.  ', '.. ', '...', ' ..', '  .', '   ']; 

        if ($this->options->getReversed()) {
            $a = array_reverse($a);
        }

        yield from $a;
    }
}
```

#### How to create your own style palette

```php
class Greeny extends AStylePalette {
    protected function ansi4StyleFrames(): Traversable
    {
        yield from [
            $this->createFrame("\e[92m%s\e[39m"),
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

    protected function getInterval(StylingMethodMode $stylingMode): ?int
    {
        return null; // due to single style frame
    }
}
```
