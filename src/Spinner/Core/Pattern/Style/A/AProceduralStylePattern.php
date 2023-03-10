<?php

declare(strict_types=1);
// 10.03.23
namespace AlecRabbit\Spinner\Core\Pattern\Style\A;

use AlecRabbit\Spinner\Core\Pattern\Contract\IProceduralPattern;
use AlecRabbit\Spinner\Core\Procedure\Contract\IProcedure;

abstract class AProceduralStylePattern extends AStylePattern implements IProceduralPattern
{
    abstract public function getPattern(): IProcedure;
}