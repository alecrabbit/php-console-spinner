### Config

Config object is created using `Settings` object values combined with values retrieved from autodetection.

 ```php
// Aux config
$auxConfig = $config->getAuxConfig();

$auxConfig->getNormalizerMode(); // NormalizerMode::BALANCED
$auxConfig->getRunMethod(); // RunMethodMode::ASYNC
$auxConfig->getLoopAvailability(); // LoopAvailabilityMode::PRESENT

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

$widgetConfig->getCharPattern(); // IBakedPattern  // default: NoStylePattern
$widgetConfig->getStylePattern(); // IBakedPattern // default: NoCharPattern
$widgetConfig->getLeadingSpacer(); // IFrame // default: new CharFrame('', 0) 
$widgetConfig->getTrailingSpacer(); // IFrame // default: new CharFrame(' ', 1)

// Root Widget config
$rootWidgetConfig = $config->getRootWidgetConfig();

$rootWidgetConfig->getCharPattern(); // IBakedPattern // default: baked Snake
$rootWidgetConfig->getStylePattern(); // IBakedPattern // default: baked Rainbow
$rootWidgetConfig->getLeadingSpacer(); // IFrame // default: new CharFrame('', 0) 
$rootWidgetConfig->getTrailingSpacer(); // IFrame // default: new CharFrame(' ', 1)

```
