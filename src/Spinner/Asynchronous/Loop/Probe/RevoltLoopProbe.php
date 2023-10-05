<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Asynchronous\Loop\Probe;

use AlecRabbit\Spinner\Asynchronous\Factory\RevoltLoopCreator;
use AlecRabbit\Spinner\Asynchronous\Loop\Adapter\RevoltLoopAdapter;
use AlecRabbit\Spinner\Core\Contract\Loop\A\ALoopProbe;
use AlecRabbit\Spinner\Core\Contract\Loop\ILoop;
use Revolt\EventLoop;

use function class_exists;

final class RevoltLoopProbe extends ALoopProbe
{
    public static function isSupported(): bool
    {
        return class_exists(EventLoop::class);
    }

    public static function getCreatorClass(): string
    {
        return RevoltLoopCreator::class;
    }

    /**
     * @deprecated
     * @codeCoverageIgnore Deprecated
     */
    public function createLoop(): ILoop
    {
        return new RevoltLoopAdapter(EventLoop::getDriver());
    }
}
