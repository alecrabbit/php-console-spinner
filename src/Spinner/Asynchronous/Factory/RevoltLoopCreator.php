<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Asynchronous\Factory;

use AlecRabbit\Spinner\Asynchronous\Loop\Adapter\RevoltLoopAdapter;
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
