<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Factory;

use AlecRabbit\Spinner\Adapter\React\ReactLoop;
use AlecRabbit\Spinner\Core\Contract\ILoop;
use AlecRabbit\Spinner\Core\Exception\DomainException;

final class LoopFactory
{
    /**
     * @throws DomainException
     */
    public static function getLoop(): ILoop
    {
        if (ReactLoop::isSupported()) {
            return
                ReactLoop::getLoop();
        }
        // FIXME (2021-12-12 21:6) [Alec Rabbit]: clarify message [e7431f81-01cc-46e8-b259-de9c63eb3e7d]
        throw new DomainException('Supported event loop object or interface is not found.');
    }
}
