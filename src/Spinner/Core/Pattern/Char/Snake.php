<?php
declare(strict_types=1);
// 09.03.23
namespace AlecRabbit\Spinner\Core\Pattern\Char;

use AlecRabbit\Spinner\Core\Contract\IInterval;
use AlecRabbit\Spinner\Core\Interval;
use AlecRabbit\Spinner\Core\Pattern\Contract\IPattern;

final class Snake implements IPattern
{
    public function getPattern(): iterable
    {
        return ['⠏', '⠛', '⠹', '⢸', '⣰', '⣤', '⣆', '⡇'];
    }

    public function getInterval(): IInterval
    {
        return new Interval(80);
    }
}