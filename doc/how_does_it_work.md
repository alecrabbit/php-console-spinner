[⬅️ to README.md](../README.md)

### How does it work?

> WIP
> - Basically, on every iteration sequence is written to output stream(`stderr` by default) and cursor is moved back by
    sequence width to its original position.

# Driver

The `Driver` is the central element of the system, responsible for rendering the current frame and sending it to the
output through its `render()` method. If no spinner is registered with the driver, nothing will be rendered and sent to
the output.

```php
$spinnerSettings = new SpinnerSettings(autoAttach: false);

$spinner = Facade::createSpinner($spinnerSettings);

$driver = Facade::getDriver();

$driver->add($spinner);
```

If an event-loop is available, the driver will be linked to the loop using `IDriverLinker` implementation. Thus, `render()` method will 
be called automatically.  

```php
$this->loop->repeat(
    $driver->getInterval()->toSeconds(),
    static fn() => $driver->render()
);
```

If no loop is available, the `render()` method must be called manually.
    
```php
$driver->render();  
```
