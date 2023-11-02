<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Core\Config\Solver;

use AlecRabbit\Spinner\Core\Config\Solver\A\ASolver;
use AlecRabbit\Spinner\Core\Config\Solver\Contract\IDriverMessagesSolver;
use AlecRabbit\Spinner\Core\Contract\IDriverMessages;
use AlecRabbit\Spinner\Core\DriverMessages;

final readonly class DriverMessagesSolver extends ASolver implements IDriverMessagesSolver
{
    public function solve(): IDriverMessages
    {
        return
            new DriverMessages(
                finalMessage: 'solver: Done',
                interruptionMessage: 'solver: Interrupted',
            );
    }
}
