<?php

declare(strict_types=1);
// 17.02.23
namespace AlecRabbit\Spinner\Core\Loop;

use AlecRabbit\Spinner\Core\Loop\A\ALoopProbe;
use AlecRabbit\Spinner\Core\Loop\Contract\ILoop;
use React\EventLoop\Loop;

use function class_exists;

final class ReactLoopProbe extends ALoopProbe
{
    public static function isSupported(): bool
    {
        return class_exists(Loop::class);
    }

    public static function create(): ILoop
    {
        return new ReactLoopAdapter(Loop::get());
    }
}
