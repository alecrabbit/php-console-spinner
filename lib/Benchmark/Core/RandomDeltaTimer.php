<?php

declare(strict_types=1);

namespace AlecRabbit\Benchmark\Core;

use AlecRabbit\Spinner\Contract\IDeltaTimer;

final readonly class RandomDeltaTimer implements IDeltaTimer
{
    public function getDelta(): float
    {
        // simulate unequal time intervals
        return (float)random_int(1000, 500000);
    }
}
