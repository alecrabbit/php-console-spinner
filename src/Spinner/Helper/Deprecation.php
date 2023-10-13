<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Helper;

use function trigger_error;

use const E_USER_DEPRECATED;

/** @codeCoverageIgnore */
final class Deprecation
{
    /** @psalm-suppress UnusedConstructor */
    final private function __construct()
    {
        // no instances, can NOT be overridden
    }

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
