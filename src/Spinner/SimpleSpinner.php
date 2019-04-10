<?php declare(strict_types=1);

namespace AlecRabbit\Spinner;

use AlecRabbit\Spinner\Core\AbstractSpinner;

class SimpleSpinner extends AbstractSpinner
{
    protected const INTERVAL = 0.16;

    /** {@inheritDoc} */
    protected function getSymbols(): array
    {
        return ['/', '|', '\\', '─',];
    }
}
