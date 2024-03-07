<?php

declare(strict_types=1);

namespace AlecRabbit\Lib\Spinner\Contract;

use AlecRabbit\Spinner\Contract\IInterval;
use AlecRabbit\Spinner\Core\Loop\Contract\ILoop;

interface ILoopInfoFormatter
{
    public function format(?ILoop $loop): string;
}
