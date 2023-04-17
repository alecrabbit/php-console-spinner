<?php

declare(strict_types=1);

// 11.03.23

namespace AlecRabbit\Spinner\Helper;

use AlecRabbit\Spinner\Mixin\NoInstanceTrait;

use function trigger_error;

use const E_USER_DEPRECATED;

/** @codeCoverageIgnore */
final class Deprecation
{
    use NoInstanceTrait;

    public static function method(string $method, ?string $message = null): void
    {
        trigger_error(
            sprintf(
                'Method "%s" is deprecated%s.',
                $method,
                $message ?? sprintf(', %s', (string)$message),
            ),
            E_USER_DEPRECATED
        );
    }
}
