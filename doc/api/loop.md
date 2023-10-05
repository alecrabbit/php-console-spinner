# Event Loop

The event loop availability is detected using loop probes. Loops are probed in the order in which the probes were added (registered) to the `Probes` class. The first probe that returns `true` from the `isSupported()` method is used to create an event loop.

> See [`Asynchronous/bootstrap.php`](../../src/Spinner/Asynchronous/bootstrap.php) for details.

## How to Disable a Specific Event Loop Probe

To disable a specific event loop probe, you can use the following code:

```php  
Probes::unregister(ReactLoopProbe::class);
``` 

## How to Add a Custom Event Loop Probe

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

    public function createLoop(): ILoop
    {
        return new CustomLoopAdapter();
    }
}
```

> See implemented `RevoltLoopProbe` and `ReactLoopProbe` classes as examples.

## Registering Loop Probe

To register the custom loop probe, use the following code:

```php
Probes::register(CustomLoopProbe::class);
```
