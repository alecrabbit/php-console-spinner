<?php

declare(strict_types=1);
// 09.03.23
namespace AlecRabbit\Spinner\Core\Pattern\Char;

use AlecRabbit\Spinner\Core\Pattern\A\AReversiblePattern;

final class Dot extends AReversiblePattern
{
    protected const UPDATE_INTERVAL = 160;

    protected function pattern(): iterable
    {
        return ['⢀', '⡀', '⠄', '⠂', '⠁', '⠈', '⠐', '⠠',];
    }
}