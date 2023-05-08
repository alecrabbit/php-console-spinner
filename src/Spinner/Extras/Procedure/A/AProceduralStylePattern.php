<?php

declare(strict_types=1);


namespace AlecRabbit\Spinner\Extras\Procedure\A;

use AlecRabbit\Spinner\Contract\Pattern\IProceduralPattern;
use AlecRabbit\Spinner\Core\Pattern\A\AStylePattern;
use AlecRabbit\Spinner\Extras\Procedure\Mixin\GetPatternMethodNotAllowedTrait;

abstract class AProceduralStylePattern extends AStylePattern implements IProceduralPattern
{
    use GetPatternMethodNotAllowedTrait;
}
