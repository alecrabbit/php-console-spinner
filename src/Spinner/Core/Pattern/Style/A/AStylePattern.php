<?php
declare(strict_types=1);
// 09.03.23
namespace AlecRabbit\Spinner\Pattern\Style\A;

use AlecRabbit\Spinner\Core\ColorMode;

abstract class APatternStyle
{
    abstract public function getMode(): ColorMode;
    abstract public function getPattern(): iterable;
}