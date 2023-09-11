### Config

Config object is created using `Settings` object values combined with values retrieved from autodetection and defaults.

 ```php
// Aux config
$auxConfig = $config->get(IAuxConfig::class); // returns AuxConfig object

$auxConfig->getNormalizerMode(); // NormalizerMode::BALANCED
$auxConfig->getRunMethodMode(); // RunMethodMode::ASYNC
$auxConfig->getLoopAvailabilityMode(); // LoopAvailabilityMode::PRESENT

// Loop config
$loopConfig = $config->get(ILoopConfig::class);

$loopConfig->getAutoStartMode(); // AutoStartMode::ENABLED
$loopConfig->getSignalHandlersMode(); // SignalHandlersMode::ENABLED
# NEW FEATURE // $outputConfig->getSignalHandlers(); // iterable <- signal handler(s)

// Output config
$outputConfig = $config->get(IOutputConfig::class); 

$outputConfig->getStylingMethodMode(); // StylingMethodMode::ANSI8
$outputConfig->getCursorVisibilityMode(); // CursorVisibilityMode::HIDDEN 
# NEW FEATURE // $outputConfig->getClearScreenMode(); // ClearScreenMode::DISABLED

// Driver config
$driverConfig = $config->get(IDriverConfig::class);

$driverConfig->getLinkerMode(); // LinkerMode::ENABLED
$driverConfig->getInitializationMode(); // InitializationMode::ENABLED

// Widget config
$widgetConfig = $config->get(IWidgetConfig::class);

$widgetConfig->getCharPattern(); // IBakedPattern  // default: NoStylePattern
$widgetConfig->getStylePattern(); // IBakedPattern // default: NoCharPattern
$widgetConfig->getLeadingSpacer(); // IFrame // default: new CharFrame('', 0) 
$widgetConfig->getTrailingSpacer(); // IFrame // default: new CharFrame(' ', 1)

// Root Widget config
$rootWidgetConfig = $config->get(IRootWidgetConfig::class);

$rootWidgetConfig->getCharPattern(); // IBakedPattern // default: baked Snake
$rootWidgetConfig->getStylePattern(); // IBakedPattern // default: baked Rainbow
$rootWidgetConfig->getLeadingSpacer(); // IFrame // default: new CharFrame('', 0) 
$rootWidgetConfig->getTrailingSpacer(); // IFrame // default: new CharFrame(' ', 1)

```
