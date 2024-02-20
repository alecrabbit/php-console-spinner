<?php

declare(strict_types=1);

use AlecRabbit\Spinner\Contract\IStyleSequenceFrame;
use AlecRabbit\Spinner\Core\Palette\A\AStylePalette;
use AlecRabbit\Spinner\Core\Palette\Contract\IPaletteMode;
use AlecRabbit\Spinner\Core\Settings\SpinnerSettings;
use AlecRabbit\Spinner\Core\Settings\WidgetSettings;
use AlecRabbit\Spinner\Core\StyleSequenceFrame;
use AlecRabbit\Spinner\Facade;

require_once __DIR__ . '/../bootstrap.async.php';

$stylePalette =
    new class() extends AStylePalette {

        protected function ansi4StyleFrames(): Traversable
        {
            yield from [
                $this->createFrame("\e[92m%s\e[39m"),
            ];
        }

        protected function modeInterval(?IPaletteMode $mode = null): ?int
        {
            return null; // due to single style frame
        }

        protected function createFrame(string $element, ?int $width = null): IStyleSequenceFrame
        {
            return new StyleSequenceFrame($element, $width ?? 0);
        }
    };

$widgetSettings =
    new WidgetSettings(
        stylePalette: $stylePalette,
    );

$spinnerSettings =
    new SpinnerSettings(
        widgetSettings: $widgetSettings,
    );

$spinner = Facade::createSpinner($spinnerSettings);
