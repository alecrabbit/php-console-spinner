<?php

declare(strict_types=1);
// 15.02.23
namespace AlecRabbit\Spinner\Helper;

use AlecRabbit\Spinner\Exception\InvalidArgumentException;
use AlecRabbit\Spinner\Exception\RuntimeException;

use function extension_loaded;

use const AlecRabbit\Cli\ALLOWED_TERM_COLOR;

final class Asserter
{
    /**
     * @param object|class-string $c
     * @param class-string $i
     * @throws InvalidArgumentException
     */
    public static function isSubClass(mixed $c, string $i, ?string $callerMethod = null, bool $allowString = true): void
    {
        if (!is_subclass_of($c, $i, $allowString)) {
            throw new InvalidArgumentException(
                sprintf(
                    'Class "%s" must be a subclass of "%s"%s.',
                    $c,
                    $i,
                    $callerMethod ? sprintf(', in "%s()"', $callerMethod) : '',
                )
            );
        }
    }

    /**
     * @throws InvalidArgumentException
     */
    public static function assertStream(mixed $stream): void
    {
        if (!is_resource($stream) || 'stream' !== get_resource_type($stream)) {
            throw new InvalidArgumentException(
                sprintf('Argument is expected to be a stream(resource), "%s" given.', get_debug_type($stream))
            );
        }
    }

    /**
     * @throws InvalidArgumentException
     */
    public static function assertColorSupportLevels(array $colorSupportLevels): void
    {
        if ($colorSupportLevels === []) {
            throw new InvalidArgumentException('Color support levels must not be empty.');
        }
        foreach ($colorSupportLevels as $level) {
            if (!in_array($level, ALLOWED_TERM_COLOR, true)) {
                throw new InvalidArgumentException(
                    sprintf(
                        'Color support level "%s" is not allowed. Allowed values are [%s].',
                        $level,
                        implode(', ', ALLOWED_TERM_COLOR)
                    )
                );
            }
        }
    }

    /**
     * @throws RuntimeException
     */
    public static function assertExtensionLoaded(string $extensionName, string $message): void
    {
        // @codeCoverageIgnoreStart
        if (!extension_loaded($extensionName)) {
            throw new RuntimeException($message);
        }
        // @codeCoverageIgnoreEnd
    }
}