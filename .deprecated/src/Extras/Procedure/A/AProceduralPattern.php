<?php

declare(strict_types=1);


namespace AlecRabbit\Spinner\Extras\Procedure\A;

use AlecRabbit\Spinner\Contract\Pattern\IProceduralPattern;
use AlecRabbit\Spinner\Core\Pattern\A\APattern;
use AlecRabbit\Spinner\Extras\Procedure\Mixin\GetPatternMethodNotAllowedTrait;

abstract class AProceduralPattern extends APattern implements IProceduralPattern
{
    use GetPatternMethodNotAllowedTrait;
}
