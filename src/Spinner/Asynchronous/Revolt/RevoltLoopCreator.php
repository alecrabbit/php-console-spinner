<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Asynchronous\Revolt;

use AlecRabbit\Spinner\Core\Contract\Loop\ILoop;
use AlecRabbit\Spinner\Core\Contract\Loop\ILoopCreator;
use Revolt\EventLoop;

final class RevoltLoopCreator implements ILoopCreator
{
    public static function create(): ILoop
    {
        return
            new RevoltLoopAdapter(EventLoop::getDriver());
    }
}
