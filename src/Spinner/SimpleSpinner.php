<?php declare(strict_types=1);

namespace AlecRabbit\Spinner;

use AlecRabbit\Spinner\Core\AbstractSpinner;

class SimpleSpinner extends AbstractSpinner
{
    /** {@inheritDoc} */
    protected function getSymbols(): array
    {
        return ['/', '/', '|', '|', '\\', '\\', '─', '─',];
    }
}
