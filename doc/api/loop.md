# Event loop

The event loop availability is detected using loop probes. Loops are probed in the reverse order in which the probes were added (registered) to the `Probes` class. The first probe that returns `true` from the `isSupported()` method is used to get event loop creator class.

> See [`Asynchronous/bootstrap.php`](../../src/Spinner/Asynchronous/bootstrap.php) for details.

## Synchronous mode

If no loop is detected, the synchronous mode is used. In this mode, the spinner is displayed only when the `render()` method is called.

```php
$spinner = Facade::createSpinner();
$driver = Facade::getDriver();

//...

$driver->render();
```

## How to disable a specific event loop probe

To disable a specific event loop probe, you can use the following code:

```php  
Probes::unregister(ReactLoopProbe::class);
``` 

## How to add a custom event loop probe

To add a custom event loop probe, you need to create a loop adapter by extending the `ALoopAdapter` class, which implements the `ILoop` interface.

```php
interface ILoop
{
    public function run(): void;

    public function stop(): void;

    public function repeat(float $interval, Closure $closure): mixed;

    public function cancel(mixed $timer): void;

    public function delay(float $delay, Closure $closure): void;

    public function onSignal(int $signal, Closure $closure): void;

    public function autoStart(): void;
}

abstract class ALoopAdapter implements ILoop
{   
    // ...
}
```
Create your implementation:
```php
class CustomLoopAdapter extends ALoopAdapter
{
  // ...   ```
}
```
> See implemented `RevoltLoopAdapter` and `ReactLoopAdapter` classes as examples.

Next, you need to create a loop probe by extending the `ALoopProbe` class and register it in the `Probes` class.
```php
class CustomLoopProbe extends ALoopProbe
{
    public static function isSupported(): bool
    {
        // ...
    }

    public static function getCreatorClass(): string
    {
        return CustomLoopCreator::class;
    }
}
```

```php
Probes::register(CustomLoopProbe::class);
```
> See implemented `RevoltLoopProbe` and `ReactLoopProbe` classes as examples.

At last, you need to create a loop creator by implementing the `ILoopCreator` interface
```php
class CustomLoopCreator implements ILoopCreator
{
    public function create(): ILoop
    {
        return
            new CustomLoopAdapter();
    }
}
```
> See implemented `RevoltLoopCreator` and `ReactLoopCreator` classes as examples.

## Registering loop probe

To register the custom loop probe, use the following code:

```php
Probes::register(CustomLoopProbe::class);
```
