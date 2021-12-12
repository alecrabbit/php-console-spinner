<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Factory;

use AlecRabbit\Spinner\Adapter\Loop\ReactLoopAdapter;
use AlecRabbit\Spinner\Contract\ILoop;
use DomainException;
use React\EventLoop\Loop;

final class LoopFactory
{
    public static function getLoop(): ILoop
    {
        if (class_exists(Loop::class)) {
            return new ReactLoopAdapter(Loop::get());
        }
        // FIXME (2021-12-12 21:6) [Alec Rabbit]: clarify message [e7431f81-01cc-46e8-b259-de9c63eb3e7d]
        throw new DomainException('Supported loop is not found.');
    }
}
