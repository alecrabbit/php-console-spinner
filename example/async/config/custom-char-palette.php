<?php

declare(strict_types=1);

use AlecRabbit\Spinner\Contract\Option\StylingMethodOption;
use AlecRabbit\Spinner\Core\CharFrame;
use AlecRabbit\Spinner\Core\Contract\ICharFrame;
use AlecRabbit\Spinner\Core\Palette\A\ACharPalette;
use AlecRabbit\Spinner\Core\Palette\NoCharPalette;
use AlecRabbit\Spinner\Core\Palette\NoStylePalette;
use AlecRabbit\Spinner\Core\Settings\OutputSettings;
use AlecRabbit\Spinner\Core\Settings\SpinnerSettings;
use AlecRabbit\Spinner\Core\Settings\WidgetSettings;
use AlecRabbit\Spinner\Facade;

require_once __DIR__ . '/../../bootstrap.php';

$charPalette =
    new class() extends ACharPalette {
        protected function createFrame(string $element): ICharFrame
        {
            return new CharFrame($element, 3); // note the width is 3
        }

        /** @inheritDoc */
        protected function sequence(): Traversable
        {
            $a = ['   ', '.  ', '.. ', '...', ' ..', '  .', '   ']; // note the width of each element

            if ($this->options->getReversed()) {
                $a = array_reverse($a);
            }

            yield from $a;
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

// perform example unrelated actions:
require_once __DIR__ . '/../bootstrap.async.php';

//dump($spinner);
