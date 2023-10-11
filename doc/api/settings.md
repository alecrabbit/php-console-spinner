# Settings

Settings are used to configure the package. Here is the list of available methods with default settings:

```php
use \AlecRabbit\Spinner\Core\Settings\AuxSettings;
use \AlecRabbit\Spinner\Core\Settings\LoopSettings;
use \AlecRabbit\Spinner\Core\Settings\OutputSettings;
use \AlecRabbit\Spinner\Core\Settings\DriverSettings;
use \AlecRabbit\Spinner\Core\Settings\WidgetSettings;
use \AlecRabbit\Spinner\Core\Settings\RootWidgetSettings;

use \AlecRabbit\Spinner\Core\Palette\Snake;
use \AlecRabbit\Spinner\Core\Palette\Rainbow;

// Aux settings
$auxSettings = new AuxSettings();

$auxSettings->setRunMethodOption(RunMethodOption::AUTO);
$auxSettings->setNormalizerOption(NormalizerOption::AUTO);

// Loop settings
$loopSettings = new LoopSettings();

$loopSettings->setAutoStartOption(AutoStartOption::AUTO);
$loopSettings->setSignalHandlersOption(SignalHandlersOption::AUTO);
# NEW FEATURE? // $loopSettings->setLoopCreatorClass(RevoltLoopCreator::class);
# NEW FEATURE? // $loopSettings->setSignalHandler(/* TBD */);

// Output settings
$outputSettings = new OutputSettings();

$outputSettings->setStylingMethodOption(StylingMethodOption::AUTO);
$outputSettings->setCursorVisibilityOption(CursorVisibilityOption::AUTO); 
# NEW FEATURE? // $outputSettings->setClearScreenOption(ClearScreenOption::AUTO);

// Driver settings
$driverSettings = new DriverSettings();

$driverSettings->setLinkerOption(LinkerOption::AUTO);
$driverSettings->setInitializationOption(InitializationOption::AUTO);
# NEW FEATURE? // $driverSettings->setTerminationOption(TerminationOption::AUTO);
# NEW FEATURE? // $driverSettings->setFinalMessage('');
# NEW FEATURE? // $driverSettings->setInterruptMessage('');

// Widget settings
$widgetSettings = new WidgetSettings();

$widgetSettings->setCharPattern(null); // default: none
$widgetSettings->setStylePattern(null); // default: none
$widgetSettings->setLeadingSpacer(null); // default: CharFrame('', 0) 
$widgetSettings->setTrailingSpacer(null); // default: CharFrame('', 0)

// Root Widget settings
$rootWidgetSettings = new RootWidgetSettings();

$rootWidgetSettings->setCharPattern(new Snake()); // default: Snake::class
$rootWidgetSettings->setStylePattern(new Rainbow()); // default: Rainbow::class
$rootWidgetSettings->setLeadingSpacer(null); // default: CharFrame('', 0) 
$rootWidgetSettings->setTrailingSpacer(null); // default: CharFrame(' ', 1)
```

```php
// Settings object
$settings = Facade::getSettings();

$settings->set(
    $auxSettings,
    $loopSettings,
    $outputSettings,
    $driverSettings,
    $widgetSettings,
    $rootWidgetSettings,
);

// to get settings
$settings->get(IAuxSettings::class); // returns AuxSettings object or null
```
