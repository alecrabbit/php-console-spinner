### Config

 ```php
// # ( TODO (2023-11-16 12:57) [Alec Rabbit]: enhance(add to) this description )
  
// Aux config
$auxConfig->getNormalizerMode(); // NormalizerMode::BALANCED
$auxConfig->getRunMethodMode(); // RunMethodMode::ASYNC

// Loop config
$loopConfig->getAutoStartMode(); // AutoStartMode::ENABLED
$loopConfig->getSignalHandlingMode(); // SignalHandlingMode::ENABLED

// Output config
$outputConfig->getStylingMethodMode(); // StylingMethodMode::ANSI8
$outputConfig->getCursorVisibilityMode(); // CursorVisibilityMode::HIDDEN
$outputConfig->getInitializationMode(); // InitializationMode::ENABLED
$outputConfig->getStream(); // STDERR

// Linker config
$linkerConfig->getLinkerMode(); // LinkerMode::ENABLED
$linkerConfig->getInitializationMode(); // InitializationMode::ENABLED

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
