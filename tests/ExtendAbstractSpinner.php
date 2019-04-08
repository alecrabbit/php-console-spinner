<?php declare(strict_types=1);

namespace AlecRabbit\Tests\Spinner;

use AlecRabbit\Accessories\Circular;
use AlecRabbit\Spinner\Core\AbstractSpinner;
use AlecRabbit\Spinner\Core\Styling;

class ExtendAbstractSpinner extends AbstractSpinner
{
    protected function getSymbols(): Circular
    {
        return new Circular(['1', '2', '3', '4',]);
    }

    protected function getStyles(): array
    {
        return [
            Styling::COLOR256_SPINNER_STYLES => null,
            Styling::COLOR_SPINNER_STYLES => [1, 2, 3, 4],
        ];
    }
}
