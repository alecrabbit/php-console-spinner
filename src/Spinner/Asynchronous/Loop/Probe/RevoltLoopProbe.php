<?php

declare(strict_types=1);
// 17.02.23

namespace AlecRabbit\Spinner\Asynchronous\Loop\Probe;

use AlecRabbit\Spinner\Asynchronous\Loop\Adapter\RevoltLoopAdapter;
use AlecRabbit\Spinner\Core\Loop\A\ALoopProbe;
use AlecRabbit\Spinner\Core\Loop\Contract\ILoop;
use Revolt\EventLoop;

use function class_exists;

/**
 * @codeCoverageIgnore
 */
class RevoltLoopProbe extends ALoopProbe
{
    public static function isAvailable(): bool
    {
        return class_exists(EventLoop::class);
    }

    public function createLoop(): ILoop
    {
        return new RevoltLoopAdapter();
    }
}
