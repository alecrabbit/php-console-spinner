<?php

declare(strict_types=1);

use AlecRabbit\Spinner\Contract\ICharSequenceFrame;
use AlecRabbit\Spinner\Contract\Option\NormalizerOption;
use AlecRabbit\Spinner\Core\CharSequenceFrame;
use AlecRabbit\Spinner\Core\Palette\A\ACharPalette;
use AlecRabbit\Spinner\Core\Palette\CustomCharPalette;
use AlecRabbit\Spinner\Core\Palette\NoStylePalette;
use AlecRabbit\Spinner\Core\Palette\PaletteOptions;
use AlecRabbit\Spinner\Core\Settings\NormalizerSettings;
use AlecRabbit\Spinner\Core\Settings\RootWidgetSettings;
use AlecRabbit\Spinner\Core\Settings\SpinnerSettings;
use AlecRabbit\Spinner\Facade;

require_once __DIR__ . '/../bootstrap.async.php';

$spinnerOne = Facade::createSpinner();

$charPalette = new CustomCharPalette(
    frames:  new ArrayObject(
        [
            new CharSequenceFrame('   ', 3),
            new CharSequenceFrame('.  ', 3),
            new CharSequenceFrame('.. ', 3),
            new CharSequenceFrame('...', 3),
            new CharSequenceFrame(' ..', 3),
            new CharSequenceFrame('  .', 3),
            new CharSequenceFrame('   ', 3),
        ]
    ),
    options: new PaletteOptions(interval: 250),
);

// Let's change default settings
Facade::getSettings()
    ->set(
        new RootWidgetSettings(
            leadingSpacer: new CharSequenceFrame('⏳ ', 3),
            stylePalette: new NoStylePalette(),
            charPalette: $charPalette,
        ),
        new NormalizerSettings(
            normalizerOption: NormalizerOption::SLOW,
        )
    )
;

$spinnerTwo = Facade::createSpinner(new SpinnerSettings(autoAttach: false));

$driver = Facade::getDriver();
$loop = Facade::getLoop();

$loop->delay(
    5, // add spinner at
    static function () use ($driver, $spinnerTwo): void {
        $driver->add($spinnerTwo);
        $driver->render(); // optional
    }
);

$loop->delay(
    15, // add spinner at
    static function () use ($driver, $spinnerOne): void {
        $driver->add($spinnerOne);
    }
);
