<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Asynchronous\React;

use AlecRabbit\Spinner\Core\Contract\Loop\A\ALoopProbe;
use React\EventLoop\Loop;

use function class_exists;

final class ReactLoopProbe extends ALoopProbe
{
    public static function isSupported(): bool
    {
        return class_exists(Loop::class);
    }

    public static function getCreatorClass(): string
    {
        return ReactLoopCreator::class;
    }
}
