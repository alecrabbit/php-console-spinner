# Settings

Settings are used to configure the package. Here is the list of available methods with default settings:

```php
$settings = Facade::getSettings();

// Aux settings
$auxSettings = $settings->getAuxSettings();

$auxSettings->setRunMethodOption(RunMethodOption::AUTO);
$auxSettings->setNormalizerOption(NormalizerOption::AUTO);

// Loop settings
$loopSettings = $settings->getLoopSettings();

$loopSettings->setAutoStartOption(AutoStartOption::AUTO);
$loopSettings->setSignalHandlersOption(SignalHandlersOption::AUTO);
# NEW FEATURE // $outputSettings->setSignalHandler(/* TBD */);

// Output settings
$outputSettings = $settings->getOutputSettings();

$outputSettings->setStylingMethodOption(StylingMethodOption::AUTO);
$outputSettings->setCursorVisibilityOption(CursorVisibilityOption::AUTO); 
# NEW FEATURE // $outputSettings->setClearScreenOption(ClearScreenOption::AUTO);

// Driver settings
$driverSettings = $settings->getDriverSettings();

$driverSettings->setLinkerOption(LinkerOption::AUTO);
$driverSettings->setInitializationOption(InitializationOption::AUTO);
# NEW FEATURE // $driverSettings->setTerminationOption(TerminationOption::AUTO);
$driverSettings->setFinalMessage('');
$driverSettings->setInterruptMessage('');

// Widget settings
$widgetSettings = $settings->getWidgetSettings();

$widgetSettings->setCharPattern(/* TBD */); // default: none
$widgetSettings->setStylePattern(/* TBD */); // default: none
$widgetSettings->setLeadingSpacer(new CharFrame('', 0)); // <- default
$widgetSettings->setTrailingSpacer(new CharFrame(' ', 1)); // <- default

// Root Widget settings
$rootWidgetSettings = $settings->getRootWidgetSettings();

$rootWidgetSettings->setCharPattern(/* TBD */); // default: Snake
$rootWidgetSettings->setStylePattern(/* TBD */); // default: Rainbow
$rootWidgetSettings->setLeadingSpacer(new CharFrame('', 0)); // <- default
$rootWidgetSettings->setTrailingSpacer(new CharFrame(' ', 1)); // <- default

```
You can override default settings by changing values in the `Settings` object.
