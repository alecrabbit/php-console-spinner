<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Core\Factory\Contract;

use AlecRabbit\Spinner\Contract\IDeltaTimer;

interface IDeltaTimerFactory
{
    public function create(): IDeltaTimer;
}
