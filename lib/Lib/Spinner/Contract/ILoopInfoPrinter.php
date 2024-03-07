<?php

declare(strict_types=1);

namespace AlecRabbit\Lib\Spinner\Contract;

use AlecRabbit\Spinner\Core\Loop\Contract\ILoop;

interface ILoopInfoPrinter
{
    public function print(?ILoop $loop): void;
}
