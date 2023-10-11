<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Asynchronous\Revolt;

use AlecRabbit\Spinner\Core\Loop\Contract\A\ALoopProbe;
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
}
