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
$loopSettings->setSignalHandlingOption(SignalHandlingOption::AUTO);
# NEW FEATURE? // $loopSettings->setSignalHandler(/* TBD */);

// Output settings
$outputSettings = new OutputSettings();

$outputSettings->setStylingMethodOption(StylingMethodOption::AUTO);
$outputSettings->setCursorVisibilityOption(CursorVisibilityOption::AUTO); 
// TODO (2023-10-16 13:56) [Alec Rabbit]: do move [36e6c435-2f98-4a19-9709-49848fd0a605]
$outputSettings->setInitializationOption(InitializationOption::AUTO); // moved from DriverSettings
# NEW FEATURE? // $outputSettings->setClearScreenOption(ClearScreenOption::AUTO);

// Driver settings
$driverSettings = new DriverSettings();

$driverSettings->setLinkerOption(LinkerOption::AUTO); // todo: check semantics
// TODO (2023-10-16 13:56) [Alec Rabbit]: do move [36e6c435-2f98-4a19-9709-49848fd0a605]
// $driverSettings->setInitializationOption(InitializationOption::AUTO); // moved to OutputSettings
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
``` 

```php
// to get settings
$settings->get(IAuxSettings::class); // returns AuxSettings object or null
```
