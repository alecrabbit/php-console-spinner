<?php

declare(strict_types=1);
// 09.03.23
namespace AlecRabbit\Spinner\Core\Terminal\Contract;

use AlecRabbit\Spinner\Core\Contract\IProbe;
use AlecRabbit\Spinner\Core\Terminal\ColorMode;

interface ITerminalProbe extends IProbe
{
    public static function getWidth(): int;

    public static function getColorMode(): ColorMode;
}