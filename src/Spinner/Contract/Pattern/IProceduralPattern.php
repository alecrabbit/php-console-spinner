<?php

declare(strict_types=1);


namespace AlecRabbit\Spinner\Contract\Pattern;

use AlecRabbit\Spinner\Contract\IProcedure;

interface IProceduralPattern
{
    public function getProcedure(): IProcedure;
}
