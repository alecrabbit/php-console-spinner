<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Asynchronous\React;

use AlecRabbit\Spinner\Core\Loop\Contract\ILoop;
use AlecRabbit\Spinner\Core\Loop\Contract\ILoopCreator;
use React\EventLoop\Loop;

final class ReactLoopCreator implements ILoopCreator
{
    public static function create(): ILoop
    {
        return
            new ReactLoopAdapter(Loop::get());
    }
}
