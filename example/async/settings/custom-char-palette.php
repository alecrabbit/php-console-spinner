<?php

declare(strict_types=1);

use AlecRabbit\Spinner\Contract\ICharSequenceFrame;
use AlecRabbit\Spinner\Core\CharSequenceFrame;
use AlecRabbit\Spinner\Core\Palette\A\ACharLegacyPalette;
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
    new class($options) extends ACharLegacyPalette {
        protected function createFrame(string $element, ?int $width = null): ICharSequenceFrame
        {
            return new CharSequenceFrame($element, $width ?? 3); // note the width is 3
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
