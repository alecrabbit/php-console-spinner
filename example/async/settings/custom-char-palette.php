<?php

declare(strict_types=1);

use AlecRabbit\Spinner\Core\CharFrame;
use AlecRabbit\Spinner\Core\Contract\ICharFrame;
use AlecRabbit\Spinner\Core\Palette\A\ACharPalette;
use AlecRabbit\Spinner\Core\Palette\PaletteOptions;
use AlecRabbit\Spinner\Core\Settings\SpinnerSettings;
use AlecRabbit\Spinner\Core\Settings\WidgetSettings;
use AlecRabbit\Spinner\Facade;

require_once __DIR__ . '/../bootstrap.async.php';

$interval = 250;
$reversed = true;

$options =
    new PaletteOptions(
        interval: $interval,
        reversed: $reversed,
    );

$charPalette =
    new class($options) extends ACharPalette {
        protected function createFrame(string $element): ICharFrame
        {
            return new CharFrame($element, 3); // note the width is 3
        }

        protected function sequence(): Traversable
        {
            yield from ['   ', '.  ', '.. ', '...', ' ..', '  .', '   ']; // note the width of each element
        }
    };

$widgetSettings =
    new WidgetSettings(
        charPalette: $charPalette,
    );

$spinnerSettings =
    new SpinnerSettings(
        widgetSettings: $widgetSettings,
    );

$spinner = Facade::createSpinner($spinnerSettings);
