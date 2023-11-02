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
---

(AI-generated from notes and code)

`Driver` is the central element of the package. Its method `render()` must be called to render the current frame and
send it to the output. In the presence of an event-loop, the driver is linked to the loop using `IDriverLinker`. In the
absence of a loop, the `render()` method must be called manually. `Driver` has an initial interval of 900 seconds. If
no spinner is registered in the driver, nothing is sent to the output.

In the presence of an event-loop, the driver is linked to the loop using `IDriverLinker`. This ensures that the driver's
method `render()` is called with the event-loop timer and that the frames are rendered at the correct time.

If no spinner is registered in the driver, the driver will not send anything to the output. This is because the spinner
is the object that provides the driver with the data to render. If there is no spinner, the driver will not have any
data to render.

---

The initial interval for the driver is set to 900 seconds.

If an event-loop is available, the driver is linked to the loop using `IDriverLinker`. If no loop is available, the
`render()` method must be called manually.

The Driver class is implemented in PHP and contains a range of interfaces and classes to support the spinner system.
The class accepts an observer object and implements the `IDriver` interface. It also makes use of other interfaces
such as `ISpinner`, `ITimer`, and `IInterval`.

The `add()` method adds a spinner to the driver, while the `remove()` method removes it. The `wrap()` method is used to
add a callback to the driver, which is executed before rendering the spinner. The `update()` method is called when a
spinner is updated.

The `interrupt()` method is used to interrupt the spinner, while the `finalize()` method is used to finalize the spinner
and send the final message to the output. The `initialize()` method initializes the driver, while the `erase()` method
is used to erase the spinner.

The `render()` method renders the current frame and sends it to the output. The `getInterval()` method returns the
interval for the spinner or driver's initial interval.
