<?php

declare(strict_types=1);


namespace AlecRabbit\Spinner\Asynchronous\Loop\Probe;

use AlecRabbit\Spinner\Asynchronous\Loop\Adapter\RevoltLoopAdapter;
use AlecRabbit\Spinner\Core\Contract\Loop\A\ALoopProbe;
use AlecRabbit\Spinner\Core\Contract\Loop\Contract\ILoop;
use Revolt\EventLoop;

use function class_exists;

/**
 * @codeCoverageIgnore
 */
class RevoltLoopProbe extends ALoopProbe
{
    public static function isSupported(): bool
    {
        return class_exists(EventLoop::class);
    }

    public function createLoop(): ILoop
    {
        return new RevoltLoopAdapter();
    }
}
