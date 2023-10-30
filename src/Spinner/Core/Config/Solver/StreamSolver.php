<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Core\Config\Solver;

use AlecRabbit\Spinner\Contract\Mode\InitializationMode;
use AlecRabbit\Spinner\Core\Config\Solver\A\ASolver;

final readonly class StreamSolver extends ASolver implements Contract\IStreamSolver
{
    public function solve(): mixed
    {
        return
            STDERR; // FIXME (2023-10-30 13:29) [Alec Rabbit]: stub!
    }
}
