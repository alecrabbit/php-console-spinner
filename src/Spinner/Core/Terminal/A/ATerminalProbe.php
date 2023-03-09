<?php
declare(strict_types=1);
// 09.03.23
namespace AlecRabbit\Spinner\Core\Terminal\A;

use AlecRabbit\Spinner\Core\ColorMode;
use AlecRabbit\Spinner\Core\Terminal\Contract\ITerminalProbe;

abstract class ATerminalProbe implements ITerminalProbe
{
    abstract public static function isSupported(): bool;

    abstract public static function getWidth(): int;

    abstract public static function getColorMode(): ColorMode;
}
