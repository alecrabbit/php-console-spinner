<?php

declare(strict_types=1);
// 10.03.23
namespace AlecRabbit\Spinner\Core\Pattern\Contract;

use AlecRabbit\Spinner\Core\Procedure\Contract\IProcedure;

interface IProceduralPattern
{
    public function getPattern(): IProcedure;
}