# Settings

Settings are used to configure the package. Here is the list of available settings with defaults:

```php
use AlecRabbit\Spinner\Core\Contract\IDriver;
use AlecRabbit\Spinner\Core\Loop\Contract\ILoop;

use AlecRabbit\Spinner\Core\Settings\GeneralSettings;
use AlecRabbit\Spinner\Core\Settings\NormalizerSettings;
use AlecRabbit\Spinner\Core\Settings\DriverSettings;
use AlecRabbit\Spinner\Core\Settings\LinkerSettings;
use AlecRabbit\Spinner\Core\Settings\LoopSettings;
use AlecRabbit\Spinner\Core\Settings\Messages;
use AlecRabbit\Spinner\Core\Settings\OutputSettings;
use AlecRabbit\Spinner\Core\Settings\RootWidgetSettings;
use AlecRabbit\Spinner\Core\Settings\WidgetSettings;

//...

// Normalizer settings
$normalizerSettings = 
    new NormalizerSettings(
        normalizerOption: NormalizerOption::AUTO, 
    );
// Revolver settings
$revolverSettings = 
    new RevolverSettings(
        tolerance: new Tolerance(5), // defaults to: Tolerance(5)
    );
 
// Widget settings
$widgetSettings = 
    new WidgetSettings(
        leadingSpacer: null, // defaults to: CharFrame('', 0)
        trailingSpacer: null, // defaults to: CharFrame('', 0)
        stylePalette: null, // defaults to: NoStylePalette()
        charPalette: null, // defaults to: NoCharPalette()
    );

// Root Widget settings
$rootWidgetSettings = 
    new RootWidgetSettings(
        leadingSpacer: null, // defaults to: WidgetConfig.leadingSpacer
        trailingSpacer: null, // defaults to: WidgetConfig.trailingSpacer
        stylePalette: null, // defaults to: new Rainbow() 
        charPalette: null, // defaults to: new Snake() 
    );
        
// Changes have no effect after configuration is created:

// General settings 
$generalSettings = 
    new GeneralSettings(
        runMethodOption: RunMethodOption::AUTO, 
    );

// Loop settings 
$loopSettings = 
    new LoopSettings(
        autoStartOption: AutoStartOption::AUTO,
        signalHandlingOption: SignalHandlingOption::AUTO,
    );

// Signal handling settings 
$onInterrupt = 
    new SignalHandlerCreator(
        signal: SIGINT, // requires pcntl-ext
        handlerCreator: new class() implements IHandlerCreator {
            public function createHandler(IDriver $driver, ILoop $loop): \Closure
            {
                return 
                    static function () use ($driver, $loop) {
                        $driver->interrupt();
                        $loop->stop();
                    }
            }
        }
    );
    
$signalHandlerSettings = 
    new SignalHandlerSettings(
        $onInterrupt,
    );

// Output settings 
$outputSettings = 
    new OutputSettings(
        stylingMethodOption: StylingMethodOption::AUTO, 
        cursorVisibilityOption: CursorVisibilityOption::AUTO, 
        initializationOption: InitializationOption::AUTO,
        stream: null, // defaults to: STDERR
    );

// Linker settings 
$linkerSettings = 
    new LinkerSettings(
        linkerOption: LinkerOption::AUTO, 
    );

// Driver settings 
$driverSettings = 
    new DriverSettings(
        messages: new Messages(
            finalMessage: null, // defaults to: ''
            interruptionMessage: null, // defaults to: ''
        )
    );
 

```

```php
// Settings object
$settings = Facade::getSettings();

$settings->set(
    $generalSettings,
    $normalizerSettings,
    $driverSettings,
    $loopSettings,
    $driverSettings,
    $linkerSettings,
    $widgetSettings,
    $revolverSettings,
    $rootWidgetSettings,
    $signalHandlerSettings,
);
``` 

```php
// to get settings
$settings->get(IGeneralSettings::class); // returns GeneralSettings object or null
```
