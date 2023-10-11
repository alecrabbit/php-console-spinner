<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Asynchronous\React;

use AlecRabbit\Spinner\Core\Contract\Loop\ILoop;
use AlecRabbit\Spinner\Core\Contract\Loop\ILoopCreator;
use React\EventLoop\Loop;

final class ReactLoopCreator implements ILoopCreator
{
    public static function create(): ILoop
    {
        return
            new ReactLoopAdapter(Loop::get());
    }
}
