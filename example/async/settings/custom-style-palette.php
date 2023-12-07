<?php

declare(strict_types=1);

use AlecRabbit\Spinner\Contract\Mode\StylingMethodMode;
use AlecRabbit\Spinner\Core\Palette\A\AStylePalette;
use AlecRabbit\Spinner\Core\Palette\Contract\IPaletteOptions;
use AlecRabbit\Spinner\Core\Palette\PaletteOptions;
use AlecRabbit\Spinner\Core\Settings\SpinnerSettings;
use AlecRabbit\Spinner\Core\Settings\WidgetSettings;
use AlecRabbit\Spinner\Facade;

require_once __DIR__ . '/../bootstrap.async.php';

$stylePalette =
    new class(new PaletteOptions()) extends AStylePalette {

        protected function ansi4StyleFrames(): Traversable
        {
            yield from [
                $this->createFrame("\e[92m%s\e[39m"),
            ];
        }

        protected function ansi8StyleFrames(): Traversable
        {
            return $this->ansi4StyleFrames();
        }

        protected function ansi24StyleFrames(): Traversable
        {
            return $this->ansi4StyleFrames();
        }

        protected function getInterval(StylingMethodMode $stylingMode): ?int
        {
            return null; // due to single style frame
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
