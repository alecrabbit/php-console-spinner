<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Asynchronous\Revolt;

use AlecRabbit\Spinner\Core\Loop\Contract\ILoop;
use AlecRabbit\Spinner\Core\Loop\Contract\ILoopCreator;
use Revolt\EventLoop;

final class RevoltLoopCreator implements ILoopCreator
{
    public function create(): ILoop
    {
        return new RevoltLoopAdapter(EventLoop::getDriver());
    }
}
