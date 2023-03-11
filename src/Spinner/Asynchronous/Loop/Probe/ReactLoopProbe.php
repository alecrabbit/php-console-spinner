<?php

declare(strict_types=1);
// 17.02.23
namespace AlecRabbit\Spinner\Asynchronous\Loop\Probe;

use AlecRabbit\Spinner\Asynchronous\Loop\A\ALoopProbe;
use AlecRabbit\Spinner\Asynchronous\Loop\Adapter\ReactLoopAdapter;
use AlecRabbit\Spinner\Asynchronous\Loop\Contract\ILoop;
use React\EventLoop\Loop;

use function class_exists;

class ReactLoopProbe extends ALoopProbe
{
    public static function isSupported(): bool
    {
        return class_exists(Loop::class);
    }

    public static function createLoop(): ILoop
    {
        return new ReactLoopAdapter(Loop::get());
    }
}
