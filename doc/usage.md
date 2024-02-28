[⬅️ to README.md](../README.md)
# Usage

* [Use cases](#use-cases)
* [Usage with event loop - Asynchronous mode(default)](#usage-with-event-loop---asynchronous-modedefault)
* [Usage without event loop - Synchronous mode](#usage-without-event-loop---synchronous-mode)
* [Custom palettes](#custom-palettes)
  * [How to create your own character palette](#how-to-create-your-own-character-palette)
  * [How to create your own style palette](#how-to-create-your-own-style-palette)

## Use cases

When to use a spinner:

 - During long-running processes to visually indicate ongoing activity and reassure users that the operation is in progress.
 - While your application is anticipating an event to provide a visual cue that the system is actively monitoring for the event.
 - During software installation processes, the spinner can indicate that the installation is ongoing and the system is progressing with the setup.

## Usage with event loop - Asynchronous mode(default)

```php
use AlecRabbit\Spinner\Facade;

$spinner = Facade::createSpinner();
```

## Usage without event loop - Synchronous mode

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

## Custom palettes

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
    
    protected function createFrame(string $element, ?int $width = null): IStyleFrame
    {
        return new StyleFrame($element, $width ?? 0);
    }
    
    protected function modeInterval(?IPaletteMode $mode = null): ?int
    {
        return null; // due to single style frame
    }
}
```
