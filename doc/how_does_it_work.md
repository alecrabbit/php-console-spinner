[⬅️ to README.md](../README.md)

### How does it work?

> WIP
> - Basically, on every iteration sequence is written to output stream(`stderr` by default) and cursor is moved back on sequence width to its original position.

# Driver

(generated from thesis and code)

`Driver` is the central element of the system. Its method `render()` must be called to render the current frame and send it to the output. `Driver` has an initial interval of 900 seconds. If no spinner is registered in the driver, nothing is sent to the output. In the presence of an event-loop, the driver is linked to the loop using DriverLinker. In the absence of a loop, the `render()` method must be called manually.

`Driver` is responsible for rendering the current frame and sending it to the output. Its method `render()` is the core function that accomplishes this task. This method must be called to ensure that the current frame is rendered and sent to the output. `Driver` also has an initial interval of 900 seconds. This means that the driver will wait for 900 seconds before rendering the next frame.

If no spinner is registered in the driver, the driver will not send anything to the output. This is because the spinner is the object that provides the driver with the data to render. If there is no spinner, the driver will not have any data to render.

In the presence of an event-loop, the driver is linked to the loop using DriverLinker. This ensures that the driver is synchronized with the event-loop and that the frames are rendered at the correct time. If there is no event-loop, the `render()` method must be called manually. This means that the driver will not be synchronized with the system clock and frames may be rendered at incorrect times.

In conclusion, the driver is a critical component of the system that is responsible for rendering frames and sending them to the output. Its method `render()` must be called to ensure that the frames are rendered and sent to the output. `Driver` also has an initial interval of 900 seconds and requires a spinner to function properly. If there is an event-loop, the driver is linked to it using DriverLinker. If there is no event-loop, the `render()` method must be called manually.

---

The Driver class is the central element of the system, responsible for rendering the current frame and sending it to the output through its `render()` method. The initial interval for the driver is set to 900 seconds. If no spinner is registered with the driver, nothing will be sent to the output.

If an event-loop is available, the driver is linked to the loop using DriverLinker. If no loop is available, the `render()` method must be called manually.

The Driver class is implemented in PHP and contains a range of interfaces and classes to support the spinner system. The class accepts an observer object and implements the `IDriver` interface. It also makes use of other interfaces such as `ISpinner`, `ITimer`, and `IInterval`.

The `add()` method adds a spinner to the driver, while the `remove()` method removes it. The `wrap()` method is used to add a callback to the driver, which is executed before rendering the spinner. The `update()` method is called when a spinner is updated.

The `interrupt()` method is used to interrupt the spinner, while the `finalize()` method is used to finalize the spinner and send the final message to the output. The `initialize()` method initializes the driver, while the `erase()` method is used to erase the spinner.

The `render()` method renders the current frame and sends it to the output, while the `recalculateInterval()` method recalculates the interval for the spinner. The `getInterval()` method returns the interval for the spinner.

Overall, the Driver class is a crucial component of the spinner system, responsible for managing the rendering and output of the spinner frames.
