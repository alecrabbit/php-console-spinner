<?php

declare(strict_types=1);
// 10.03.23
namespace AlecRabbit\Spinner\Extras\Procedure\Contract;

interface IProceduralPattern
{
    public function getProcedure(): IProcedure;
}