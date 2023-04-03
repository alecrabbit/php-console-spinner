<?php

declare(strict_types=1);
// 17.02.23

namespace AlecRabbit\Spinner\Asynchronous\Loop\Probe;

use AlecRabbit\Spinner\Asynchronous\Loop\Adapter\ReactLoopAdapter;
use AlecRabbit\Spinner\Core\Loop\A\ALoopProbe;
use AlecRabbit\Spinner\Core\Loop\Contract\ILoopAdapter;
use React\EventLoop\Loop;

use function class_exists;

/**
 * @codeCoverageIgnore
 */
class ReactLoopProbe extends ALoopProbe
{
    public static function isSupported(): bool
    {
        return class_exists(Loop::class);
    }

    public function createLoop(): ILoopAdapter
    {
        return new ReactLoopAdapter(Loop::get());
    }
}
