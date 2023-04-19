<?php

declare(strict_types=1);

// 10.03.23

namespace AlecRabbit\Spinner\Extras\Procedure\A;

use AlecRabbit\Spinner\Contract\Pattern\IProceduralPattern;
use AlecRabbit\Spinner\Core\Pattern\StylePattern\A\ALegacyStylePattern;
use AlecRabbit\Spinner\Extras\Procedure\Mixin\GetPatternMethodNotAllowedTrait;

abstract class AProceduralStylePattern extends ALegacyStylePattern implements IProceduralPattern
{
    use GetPatternMethodNotAllowedTrait;
}
