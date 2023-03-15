<?php

declare(strict_types=1);
// 10.03.23
namespace AlecRabbit\Spinner\Extras\Procedure\A;

use AlecRabbit\Spinner\Contract\IProceduralPattern;
use AlecRabbit\Spinner\Core\Pattern\Style\A\AStylePattern;
use AlecRabbit\Spinner\Extras\Procedure\Mixin\GetPatternMethodNotAllowedTrait;

abstract class AProceduralStylePattern extends AStylePattern implements IProceduralPattern
{
    use GetPatternMethodNotAllowedTrait;
}