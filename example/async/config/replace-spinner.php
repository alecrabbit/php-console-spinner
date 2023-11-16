<?php

declare(strict_types=1);

use AlecRabbit\Spinner\Contract\Option\NormalizerOption;
use AlecRabbit\Spinner\Core\CharFrame;
use AlecRabbit\Spinner\Core\Contract\ICharFrame;
use AlecRabbit\Spinner\Core\Palette\A\ACharPalette;
use AlecRabbit\Spinner\Core\Palette\NoStylePalette;
use AlecRabbit\Spinner\Core\Settings\AuxSettings;
use AlecRabbit\Spinner\Core\Settings\RootWidgetSettings;
use AlecRabbit\Spinner\Core\Settings\SpinnerSettings;
use AlecRabbit\Spinner\Facade;

require_once __DIR__ . '/../bootstrap.async.php';

$spinnerOne = Facade::createSpinner();

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

Facade::getSettings()
    ->set(
        new RootWidgetSettings(
            leadingSpacer: new CharFrame('⏳ ', 3),
            stylePalette: new NoStylePalette(),
            charPalette: $charPalette,
        ),
        new AuxSettings(
            normalizerOption: NormalizerOption::SLOW,
        )
    )
;

$driver = Facade::getDriver();
$loop = Facade::getLoop();

$spinnerTwo = Facade::createSpinner(new SpinnerSettings(autoAttach: false));

$loop->delay(
    5, // add spinner at
    static function () use ($driver, $spinnerTwo): void {
        $driver->add($spinnerTwo);
    }
);

$loop->delay(
    15, // add spinner at
    static function () use ($driver, $spinnerOne): void {
        $driver->add($spinnerOne);
    }
);
