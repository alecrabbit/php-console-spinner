<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Asynchronous\Loop\Probe;

use AlecRabbit\Spinner\Asynchronous\Loop\Adapter\ReactLoopAdapter;
use AlecRabbit\Spinner\Asynchronous\Loop\Creator\ReactLoopCreator;
use AlecRabbit\Spinner\Core\Contract\Loop\A\ALoopProbe;
use AlecRabbit\Spinner\Core\Contract\Loop\ILoop;
use React\EventLoop\Loop;

use function class_exists;

final class ReactLoopProbe extends ALoopProbe
{
    public static function isSupported(): bool
    {
        return class_exists(Loop::class);
    }

    /**
     * @deprecated
     * @codeCoverageIgnore Deprecated
     */
    public function createLoop(): ILoop
    {
        return new ReactLoopAdapter(Loop::get());
    }

    public static function getCreatorClass(): string
    {
        return ReactLoopCreator::class;
    }
}
