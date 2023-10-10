<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Asynchronous\Revolt;

use AlecRabbit\Spinner\Core\Contract\Loop\A\ALoopProbe;
use AlecRabbit\Spinner\Core\Contract\Loop\ILoop;
use AlecRabbit\Spinner\Exception\RuntimeException;
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
