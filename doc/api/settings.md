# Settings

Settings are used to configure the package. Here is the list of available methods with default settings:

```php
use AlecRabbit\Spinner\Core\Settings\AuxSettings;
use AlecRabbit\Spinner\Core\Settings\DriverSettings;
use AlecRabbit\Spinner\Core\Settings\LoopSettings;
use AlecRabbit\Spinner\Core\Settings\OutputSettings;
use AlecRabbit\Spinner\Core\Settings\RootWidgetSettings;
use AlecRabbit\Spinner\Core\Settings\WidgetSettings;

// Aux settings
$auxSettings = 
    new AuxSettings(
        runMethodOption: $runMethodOption, // RunMethodOption::AUTO,
        normalizerOption: $normalizerOption, // NormalizerOption::AUTO,
    );

// Loop settings
$loopSettings = 
    new LoopSettings(
        autoStartOption: $autoStartOption, // AutoStartOption::AUTO,
        signalHandlersOption: $signalHandlersOption, // SignalHandlingOption::AUTO,
    );
# NEW FEATURE? // $loopSettings? SignalHandler(/* TBD */); // todo: api

// Output settings
$outputSettings = 
    new OutputSettings(
        stylingMethodOption: $stylingMethodOption, // StylingMethodOption::AUTO,
        cursorVisibilityOption: $cursorVisibilityOption, // CursorVisibilityOption::AUTO,
        initializationOption: $initializationOption, // InitializationOption::AUTO // todo: do move from driver settings [36e6c435-2f98-4a19-9709-49848fd0a605]
    );

# NEW FEATURE? // $outputSettings? ClearScreenOption(ClearScreenOption::AUTO);

// Driver settings
$driverSettings = 
    new DriverSettings(
        linkerOption: $linkerOption, // LinkerOption::AUTO // todo: check semantics
        initializationOption: $initializationOption, // InitializationOption::AUTO // todo: do move to output settings [36e6c435-2f98-4a19-9709-49848fd0a605]
    );
# NEW FEATURE? // $driverSettings? FinalMessage(''); // todo: where to put it?
# NEW FEATURE? // $driverSettings? InterruptMessage(''); // todo: where to put it?

// Widget settings
$widgetSettings = 
    new WidgetSettings(
        leadingSpacer: $leadingSpacer, // null, defaults to: CharFrame('', 0)
        trailingSpacer: $trailingSpacer, // null, defaults to: CharFrame('', 0)
        stylePalette: $stylePalette, // null, defaults to: none
        charPalette: $charPalette, // null, defaults to: none
    );

// Root Widget settings
$rootWidgetSettings = 
    new RootWidgetSettings(
        leadingSpacer: $leadingSpacer, // null, defaults to: WidgetConfig.leadingSpacer
        trailingSpacer: $trailingSpacer, // null, defaults to: WidgetConfig.trailingSpacer
        stylePalette: $stylePalette, // null, defaults to: new Rainbow() 
        charPalette: $charPalette, // null, defaults to: new Snake() 
    );
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
