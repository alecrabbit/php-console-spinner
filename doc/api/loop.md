### Event Loop

To detect event loop availability loop probes are used. See `Asynchronous/bootstrap.php` for details.
Loops are probed in order probes were added(registered) to `LoopProbeFactory` class. First probe that
returns `true` from `isSupported()` method is used as event loop.

#### Custom Event Loop Probe

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
```
> See implemented `RevoltLoopAdapter` and `ReactLoopAdapter` classes as examples.

Then you need to create a loop probe by extending `ALoopProbe` class and register it in `LoopProbeFactory` class.

```php
class RevoltLoopProbe extends ALoopProbe
{
    public static function isSupported(): bool
    {
        return class_exists(EventLoop::class);
    }

    public function createLoop(): ILoop
    {
        return new RevoltLoopAdapter();
    }
}
```

##### Registering Loop Probe

```php
/* TBD */
```
