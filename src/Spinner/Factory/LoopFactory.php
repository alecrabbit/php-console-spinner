<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Factory;

use AlecRabbit\Spinner\Adapter\Loop\ReactLoopAdapter;
use AlecRabbit\Spinner\Contract\ILoop;
use React\EventLoop\Loop;

final class LoopFactory
{
    public static function getLoop(): ILoop
    {
        return new ReactLoopAdapter(Loop::get());
    }
}
