<?php

declare(strict_types=1);

use AlecRabbit\Spinner\Contract\ICharSequenceFrame;
use AlecRabbit\Spinner\Contract\Option\NormalizerOption;
use AlecRabbit\Spinner\Core\CharSequenceFrame;
use AlecRabbit\Spinner\Core\Palette\A\ACharPalette;
use AlecRabbit\Spinner\Core\Palette\NoStylePalette;
use AlecRabbit\Spinner\Core\Settings\NormalizerSettings;
use AlecRabbit\Spinner\Core\Settings\RootWidgetSettings;
use AlecRabbit\Spinner\Core\Settings\SpinnerSettings;
use AlecRabbit\Spinner\Facade;

require_once __DIR__ . '/../bootstrap.async.php';

$spinnerOne = Facade::createSpinner();

$charPalette =
    new class() extends ACharPalette {
        protected function createFrame(string $element, ?int $width = null): ICharSequenceFrame
        {
            return new CharSequenceFrame($element, $width ?? 3); // note the width is 3
        }

        protected function sequence(): Traversable
        {
            yield from ['   ', '.  ', '.. ', '...', ' ..', '  .', '   ']; // note the width of each element
        }
    };

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
