<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Contract;

interface IDeltaTimer
{
    public function getDelta(): float;
}
