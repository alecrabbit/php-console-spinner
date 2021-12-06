<?php

declare(strict_types=1);

namespace AlecRabbit\SpinnerOld\Core\Adapters;

use AlecRabbit\SpinnerOld\Core\Contracts\OutputInterface;

abstract class AbstractOutputAdapter implements OutputInterface
{
    /** {@inheritDoc} */
    public function writeln($messages, $options = 0): void
    {
        $this->write($messages, true, $options);
    }
}
