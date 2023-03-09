<?php
declare(strict_types=1);
// 09.03.23
namespace AlecRabbit\Spinner\Core\Pattern\Style\A;

use AlecRabbit\Spinner\Core\ColorMode;
use AlecRabbit\Spinner\Core\Contract\IInterval;

abstract class AStylePattern
{
    abstract public function getMode(): ColorMode;

    abstract public function getPattern(): iterable;

    abstract public function getInterval(): IInterval;
}