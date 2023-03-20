<?php

declare(strict_types=1);
// 15.02.23

namespace AlecRabbit\Spinner\Helper;

use AlecRabbit\Spinner\Contract\ColorMode;
use AlecRabbit\Spinner\Exception\InvalidArgumentException;
use AlecRabbit\Spinner\Exception\RuntimeException;
use Traversable;

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
    public static function isSubClass(
        object|string $c,
        string $i,
        ?string $callerMethod = null,
        bool $allowString = true
    ): void {
        if (!is_subclass_of($c, $i, $allowString)) {
            throw new InvalidArgumentException(
                sprintf(
                    'Class "%s" must be a subclass of "%s"%s.',
                    is_object($c) ? get_class($c) : $c,
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
        /** @psalm-suppress DocblockTypeContradiction */
        if (!is_resource($stream) || 'stream' !== get_resource_type($stream)) {
            throw new InvalidArgumentException(
                sprintf('Argument is expected to be a stream(resource), "%s" given.', get_debug_type($stream))
            );
        }
    }

    /**
     * @throws InvalidArgumentException
     */
    public static function assertColorModes(Traversable $colorModes): void
    {
        if (0 === count(iterator_to_array($colorModes))) {
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
