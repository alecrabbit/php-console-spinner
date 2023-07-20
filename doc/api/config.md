### Config

Config object is created using `Settings` object values combined with values retrieved from autodetection.

 ```php
// Package config
$config->getRunMethod(); // RunMethodMode::ASYNC
$config->getLoopAvailability(); // LoopAvailabilityMode::PRESENT

// Aux config
$auxConfig = $config->getAuxConfig();

$auxConfig->getNormalizerMode(); // NormalizerMode::BALANCED

// Loop config
$loopConfig = $config->getLoopConfig();

$loopConfig->getAutoStartMode(); // AutoStartMode::ENABLED
$loopConfig->getSignalHandlersMode(); // SignalHandlersMode::ENABLED
# NEW FEATURE // $outputConfig->getSignalHandlers(); // iterable <- signal handler(s)

// Output config
$outputConfig = $config->getOutputConfig();

$outputConfig->getStylingMethodMode(); // StylingMethodMode::ANSI8
$outputConfig->getCursorVisibilityMode(); // CursorVisibilityMode::HIDDEN 
# NEW FEATURE // $outputConfig->getClearScreenMode(); // ClearScreenMode::DISABLED

// Driver config
$driverConfig = $config->getDriverConfig();

$driverConfig->getLinkerMode(); // LinkerMode::ENABLED
$driverConfig->getInitializationMode(); // InitializationMode::ENABLED

// Widget config
$widgetConfig = $config->getWidgetConfig();

$widgetConfig->getCharPattern(); /* TBD */ // default: none
$widgetConfig->getStylePattern(); /* TBD */ // default: none
$widgetConfig->getLeadingSpacer(); // new CharFrame('', 0) 
$widgetConfig->getTrailingSpacer(); // new CharFrame(' ', 1)

// Root Widget config
$rootWidgetConfig = $config->getRootWidgetConfig();

$rootWidgetConfig->getCharPattern(); /* TBD */ // default: Snake
$rootWidgetConfig->getStylePattern(); /* TBD */ // default: Rainbow
$rootWidgetConfig->getLeadingSpacer(); // new CharFrame('', 0) 
$rootWidgetConfig->getTrailingSpacer(); // new CharFrame(' ', 1)

```
