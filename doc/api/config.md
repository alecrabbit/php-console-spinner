### Config

 ```php
// General config
$generalConfig->getExecutionMode(); // ExecutionMode::ASYNC

// Normalizer config
$normalizerConfig->getNormalizerMode(); // NormalizerMode::BALANCED

// Loop config
$loopConfig->getAutoStartMode(); // AutoStartMode::ENABLED
$loopConfig->getSignalHandlingMode(); // SignalHandlingMode::ENABLED
$loopConfig->getSignalHandlersContainer(); // ISignalHandlersContainer (SIGINT handler by default)

// Output config
$outputConfig->getStylingMode(); // StylingMode::ANSI8
$outputConfig->getCursorVisibilityMode(); // CursorVisibilityMode::HIDDEN
$outputConfig->getInitializationMode(); // InitializationMode::ENABLED
$outputConfig->getStream(); // STDERR

// Linker config
$linkerConfig->getLinkerMode(); // LinkerMode::ENABLED

// Driver config
$driverConfig->getDriverMessages(); // IDriverMessages(empty strings by default) 

// Widget config
$widgetConfig->getCharPalette(); // default: NoStylePalette
$widgetConfig->getStylePalette(); // default: NoCharPalette
$widgetConfig->getLeadingSpacer(); // default: new CharFrame('', 0) 
$widgetConfig->getTrailingSpacer(); // default: new CharFrame(' ', 1)

// Root Widget config
$rootWidgetConfig->getCharPalette(); // default: Snake
$rootWidgetConfig->getStylePalette(); // default: Rainbow
$rootWidgetConfig->getLeadingSpacer(); // default: new CharFrame('', 0) 
$rootWidgetConfig->getTrailingSpacer(); // default: new CharFrame(' ', 1)

```
