<?php declare(strict_types=1);

namespace AlecRabbit\Tests\Spinner;

use AlecRabbit\Accessories\Circular;
use AlecRabbit\Spinner\Core\AbstractSpinner;

class ExtendAbstractSpinner extends AbstractSpinner
{
    protected function getSymbols(): Circular
    {
        return new Circular(['1', '2', '3', '4',]);
    }

    protected function getStyles(): ?Circular
    {
        return new Circular(['1', '2', '3', '4',]);
    }
}
