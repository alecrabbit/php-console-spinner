```mermaid
flowchart TD
    A[Start] --> B{Is it?}
    B -- Yes --> C[OK]
    C --> D[Rethink]
    D --> B
    B -- No ----> E[End]
```

```mermaid
flowchart TD
    A[Start] --> B[Settings] 
    B --> C{Loop?}
    B --> D{Output?}
    B --> E{Color?}
```
- SettingsProvider created 
  - probing for event loop --> Loop settings

- Driver created by DriverFactory



- probing for event loop
  - ReactPHP            --> ReactPHP
  - Revolt              --> Revolt
  - No event loop found --> No Loop(Synchronous Mode)
- probing for output stream
  - symfony/console     --> STDERR(from symfony/console)
  - No output found     --> STDERR("native")
- probing for terminal color support
  - symfony/console     --> ANSI(from symfony/console)
  - No color support    --> ANSI("native")

```mermaid
flowchart LR
    A[Loop] --> AB[React] 
    A[Loop] --> AC[Revolt] 
    A[Loop] --> AD[None]
    B[Output] --> BA[Symfony]
    B[Output] --> BB[None]
    B[Output] --> BC[Native]
```

Loop:
- autodetect event loop (ReactPHP, Revolt, None)
- option:
  - attach handler(s) to loop - ENABLED/DISABLED (signal handler(s)), 🔧 **Default** ➜ ENABLED
  - autostart loop - ENABLED/DISABLED, 🔧 **Default** ➜ ENABLED
  - run mode (sync/async) - SYNCHRONOUS/ASYNC, 🔧 **Default** ➜ ASYNC

Output:
- autodetect stream (symfony/console, None), 🔧 **Default** ➜ stderr
  - custom stream (new feature)
- option:
  - show/hide cursor - VISIBLE/HIDDEN, 🔧 **Default** ➜ HIDDEN
  - clear screen - ENABLED/DISABLED (new feature), 🔧 **Default** ➜ DISABLED
  - initialization - ENABLED/DISABLED (execute all options for output?), 🔧 **Default** ➜ ENABLED

Color:
- autodetect color support (symfony/console, None), 🔧 **Default** ➜ ANSI8
- option:
  - color mode (AUTO, NONE, ANSI4, ANSI8, ANSI24), 🔧 **Default** ➜ AUTO

Driver:
- option:
  - linker - ENABLED/DISABLED (link driver to loop), 🔧 **Default** ➜ ENABLED

Normalizer: (for minimal frames interval step)
- SMOOTH/BALANCED/PERFORMANCE/SLOW/STILL, 🔧 **Default** ➜ BALANCED (50ms)


### Usage

You can override default settings by changing settings in SettingsProvider.
```php
$settings = Facade::getSettings();

// Package Settings
$settings->setRunMethod(RunMethodOption::AUTO);

// Aux settings
$auxSettings = $settings->getAuxSettings();

$auxSettings->setNormalizerOption(NormalizerOption::AUTO);

// Loop settings
$loopSettings = $settings->getLoopSettings();

$loopSettings->setAutoStartOption(AutoStartOption::AUTO);
$loopSettings->setSignalHandlersOption(SignalHandlersOption::AUTO);

// Output settings
$outputSettings = $settings->getOutputSettings();

$outputSettings->setStylingMethodOption(StylingMethodOption::AUTO);
$outputSettings->setCursorVisibilityOption(CursorVisibilityOption::AUTO);

// Driver settings
$driverSettings = $settings->getDriverSettings();

$driverSettings->setLinkerOption(LinkerOption::AUTO);
$driverSettings->setInitializationOption(InitializationOption::AUTO);

// Widget settings
$widgetSettings = $settings->getWidgetSettings();

$widgetSettings->setCharPattern(/* TBA */); // default: none
$widgetSettings->setStylePattern(/* TBA */); // default: none
$widgetSettings->setLeadingSpacer(new CharFrame('', 0)); // <- default
$widgetSettings->setTrailingSpacer(new CharFrame(' ', 1)); // <- default

// Root Widget settings
$rootWidgetSettings = $settings->getRootWidgetSettings();

$rootWidgetSettings->setCharPattern(/* TBA */); // default: Snake
$rootWidgetSettings->setStylePattern(/* TBA */); // default: Rainbow
$rootWidgetSettings->setLeadingSpacer(new CharFrame('', 0)); // <- default
$rootWidgetSettings->setTrailingSpacer(new CharFrame(' ', 1)); // <- default

```
