<?php
declare(strict_types=1);
// 09.03.23
namespace AlecRabbit\Spinner\Core\Pattern\Style\A;

use AlecRabbit\Spinner\Core\ColorMode;
use AlecRabbit\Spinner\Core\Contract\IInterval;
use AlecRabbit\Spinner\Core\Pattern\Contract\IStylePattern;

abstract class AStylePattern implements IStylePattern
{
    abstract public function getColorMode(): ColorMode;

    abstract public function getPattern(): iterable;

    abstract public function getInterval(): IInterval;
}