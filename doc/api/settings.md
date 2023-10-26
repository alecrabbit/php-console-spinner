# Settings

Settings are used to configure the package. Here is the list of available settings with defaults:

```php
use AlecRabbit\Spinner\Core\Settings\AuxSettings;
use AlecRabbit\Spinner\Core\Settings\DriverSettings;
use AlecRabbit\Spinner\Core\Settings\LoopSettings;
use AlecRabbit\Spinner\Core\Settings\OutputSettings;
use AlecRabbit\Spinner\Core\Settings\RootWidgetSettings;
use AlecRabbit\Spinner\Core\Settings\WidgetSettings;
use \AlecRabbit\Spinner\Core\Loop\Contract\ILoop;
use \AlecRabbit\Spinner\Core\Contract\IDriver;

// Aux settings
$auxSettings = 
    new AuxSettings(
        runMethodOption: RunMethodOption::AUTO, 
        normalizerOption: NormalizerOption::AUTO, 
    );

// Loop settings
$loopSettings = 
    new LoopSettings(
        autoStartOption: AutoStartOption::AUTO,
        signalHandlingOption: SignalHandlingOption::AUTO,
    );

// Signal handling settings
$onKill = 
    new SignalHandlerCreator(
        signal: SIGKILL,
        handlerCreator: static function (IDriver $driver, ILoop $loop ) {
            return static function () use ($driver, $loop) {
                $driver->finalize();
                $loop->stop();
            };
        }
    );
    
$signalHandlerCreators = 
    new SignalHandlerCreators(
        $onKill,
    );

// Output settings
$outputSettings = 
    new OutputSettings(
        stylingMethodOption: StylingMethodOption::AUTO, 
        cursorVisibilityOption: CursorVisibilityOption::AUTO, 
        initializationOption: InitializationOption::AUTO, // todo: do move from driver settings [36e6c435-2f98-4a19-9709-49848fd0a605]
    );

// # NEW FEATURE: $outputSettings? ClearScreenOption(ClearScreenOption::AUTO);

// Driver settings
$driverSettings = 
    new DriverSettings(
        linkerOption: LinkerOption::AUTO, // todo: check semantics
        initializationOption: InitializationOption::AUTO, // todo: do move to output settings [36e6c435-2f98-4a19-9709-49848fd0a605]
    );
// # NEW FEATURE: $driverSettings? FinalMessage(''); // todo: where to put it?
// # NEW FEATURE: $driverSettings? InterruptMessage(''); // todo: where to put it?

// Widget settings
$widgetSettings = 
    new WidgetSettings(
        leadingSpacer: null, // defaults to: CharFrame('', 0)
        trailingSpacer: null, // defaults to: CharFrame('', 0)
        stylePalette: null, // defaults to: none
        charPalette: null, // defaults to: none
    );

// Root Widget settings
$rootWidgetSettings = 
    new RootWidgetSettings(
        leadingSpacer: null, // defaults to: WidgetConfig.leadingSpacer
        trailingSpacer: null, // defaults to: WidgetConfig.trailingSpacer
        stylePalette: null, // defaults to: new Rainbow() 
        charPalette: null, // defaults to: new Snake() 
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
    $signalHandlerCreators,
);
``` 

```php
// to get settings
$settings->get(IAuxSettings::class); // returns AuxSettings object or null
```
