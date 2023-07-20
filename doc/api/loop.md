### Event Loop

To detect event loop availability loop probes are used. 
Loops are probed in order probes were added(registered) to `Probes` class. First probe that
returns `true` from `isSupported()` method is used as event loop.

> See `Asynchronous/bootstrap.php` for details.

#### How to disable specific event loop probe

```php  
Probes::unregister(ReactLoopProbe::class);
``` 

#### How to add custom event loop probe

To add custom event loop probe you need to create a loop adapter by extending `ALoopAdapter` class which implements 
`ILoop` interface.

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
Create ypur implementation
```php
class CustomLoopAdapter extends ALoopAdapter
{
  // ...   ```
}
```
> See implemented `RevoltLoopAdapter` and `ReactLoopAdapter` classes as examples.

Then you need to create a loop probe by extending `ALoopProbe` class and register it in `Probes` class.

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

##### Registering Loop Probe

```php
Probes::register(CustomLoopProbe::class);
```
