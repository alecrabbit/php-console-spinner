<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Core\Factory;

use AlecRabbit\Spinner\Adapter\React\ReactLoop;
use AlecRabbit\Spinner\Core\Contract\ILoop;
use AlecRabbit\Spinner\Core\Exception\DomainException;
use AlecRabbit\Spinner\Core\Factory\Contract\ILoopFactory;

final class LoopFactory implements ILoopFactory
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
        throw self::getNoLoopException();
    }

    private static function getNoLoopException(): DomainException
    {
        // TODO (2022-06-10 18:21) [Alec Rabbit]: clarify message [248e8c9c-ca5d-47bb-92d2-267b25165425]
        return new DomainException(
            sprintf(
                'Failed to retrieve event loop object. Please install: [%s].',
                implode(', ', self::supported()),
            )

        );
    }

    public static function supported(): array
    {
        return
            [
                ReactLoop::getPackageName(),
            ];
    }
}
