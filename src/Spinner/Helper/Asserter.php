<?php

declare(strict_types=1);
// 15.02.23
namespace AlecRabbit\Spinner\Helper;

use AlecRabbit\Spinner\I\ColorMode;
use AlecRabbit\Spinner\Exception\InvalidArgumentException;
use AlecRabbit\Spinner\Exception\RuntimeException;

use function class_exists;
use function extension_loaded;

final class Asserter
{
    /**
     * @param object|class-string $c
     * @param class-string $i
     * @param string|null $callerMethod
     * @param bool $allowString
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
                    $callerMethod ? sprintf(', see "%s()"', $callerMethod) : '',
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
    public static function assertColorModes(iterable $colorModes): void
    {
        if (0 === iterator_count($colorModes)) {
            throw new InvalidArgumentException('Color modes must not be empty.');
        }
        /** @var ColorMode $colorMode */
        foreach ($colorModes as $colorMode) {
            if (!$colorMode instanceof ColorMode) {
                throw new InvalidArgumentException(
                    sprintf(
                        'Unsupported color mode of type "%s".',
                        get_debug_type($colorMode)
                    )
                );
            }
        }

//        foreach ($colorModes as $level) {
//            if (!in_array($level, KNOWN_TERM_COLOR, true)) {
//                throw new InvalidArgumentException(
//                    sprintf(
//                        'Color support mode "%s" is not allowed. Allowed values are [%s].',
//                        $level,
//                        implode(', ', KNOWN_TERM_COLOR)
//                    )
//                );
//            }
//        }
    }

    /**
     * @throws RuntimeException
     */
    public static function assertExtensionLoaded(string $extensionName, ?string $message = null): void
    {
        if (!extension_loaded($extensionName)) {
            throw new RuntimeException(
                $message ?? sprintf('Extension "%s" is not loaded.', $extensionName)
            );
        }
    }

    /**
     * @throws InvalidArgumentException
     */
    public static function classExists(string $class, ?string $callerMethod = null): void
    {
        if (!class_exists($class)) {
            throw new InvalidArgumentException(
                sprintf(
                    'Class "%s" does not exist%s.',
                    $class,
                    $callerMethod ? sprintf(', see "%s()"', $callerMethod) : ''
                )
            );
        }
    }
}
