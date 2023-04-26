<?php

declare(strict_types=1);

// 17.02.23

namespace AlecRabbit\Spinner\Asynchronous\Loop\Probe;

use AlecRabbit\Spinner\Asynchronous\Loop\Adapter\ReactLoopAdapter;
use AlecRabbit\Spinner\Core\Contract\Loop\A\ALoopProbe;
use AlecRabbit\Spinner\Core\Contract\Loop\Contract\ILoop;
use React\EventLoop\Loop;

use function class_exists;

/**
 * @codeCoverageIgnore
 */
class ReactLoopProbe extends ALoopProbe
{
    public static function isAvailable(): bool
    {
        return class_exists(Loop::class);
    }

    public function createLoop(): ILoop
    {
        return new ReactLoopAdapter(Loop::get());
    }
}
