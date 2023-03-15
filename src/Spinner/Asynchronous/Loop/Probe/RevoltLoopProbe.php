<?php

declare(strict_types=1);
// 17.02.23
namespace AlecRabbit\Spinner\Asynchronous\Loop\Probe;

use AlecRabbit\Spinner\Asynchronous\Loop\Adapter\RevoltLoopAdapter;
use AlecRabbit\Spinner\Asynchronous\Loop\Probe\A\ALoopProbe;
use AlecRabbit\Spinner\Core\Contract\ILoopAdapter;
use Revolt\EventLoop;

use function class_exists;

class RevoltLoopProbe extends ALoopProbe
{
    public static function isSupported(): bool
    {
        return class_exists(EventLoop::class);
    }

    public static function createLoop(): ILoopAdapter
    {
        return new RevoltLoopAdapter();
    }
}
