<?php

declare(strict_types=1);

// 10.03.23

namespace AlecRabbit\Spinner\Contract\Pattern;

use AlecRabbit\Spinner\Contract\IProcedure;

interface IProceduralPattern
{
    public function getProcedure(): IProcedure;
}
