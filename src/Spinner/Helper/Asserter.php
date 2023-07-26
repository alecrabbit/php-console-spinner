<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Helper;

use AlecRabbit\Spinner\Contract\Option\StylingMethodOption;
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
     *
     * @throws InvalidArgumentException
     */
    public static function assertIsSubClass(
        object|string $c,
        string $i,
        ?string $callerMethod = null,
        bool $allowString = true
    ): void {
        if (!is_subclass_of($c, $i, $allowString)) {
            throw new InvalidArgumentException(
                sprintf(
                    'Class "%s" must be a subclass of "%s"%s.',
                    is_object($c) ? $c::class : $c,
                    $i,
                    self::getSeeMethodStr($callerMethod),
                )
            );
        }
    }

    private static function getSeeMethodStr(?string $callerMethod): string
    {
        return $callerMethod
            ? sprintf(', see "%s()"', $callerMethod)
            : '';
    }

    /**
     * @param resource $stream
     *
     * @throws InvalidArgumentException
     */
    public static function assertStream(mixed $stream): void
    {
        /** @psalm-suppress DocblockTypeContradiction */
        if (!is_resource($stream) || get_resource_type($stream) !== 'stream') {
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
        if (count(iterator_to_array($colorModes)) === 0) {
            throw new InvalidArgumentException('Color modes must not be empty.');
        }
        /** @var StylingMethodOption $colorMode */
        foreach ($colorModes as $colorMode) {
            if (!$colorMode instanceof StylingMethodOption) {
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
    public static function assertClassExists(string $class, ?string $callerMethod = null): void
    {
        if (!class_exists($class)) {
            throw new InvalidArgumentException(
                sprintf(
                    'Class "%s" does not exist%s.',
                    $class,
                    self::getSeeMethodStr($callerMethod)
                )
            );
        }
    }

    /**
     * @throws InvalidArgumentException
     */
    public static function assertHexStringColor(string $entry): void
    {
        $strlen = strlen($entry);
        $entry = strtolower($entry);
        match (true) {
            0 === $strlen => throw new InvalidArgumentException(
                'Value should not be empty string.'
            ),
            !str_starts_with($entry, '#') => throw new InvalidArgumentException(
                sprintf(
                    'Value should be a valid hex color code("#rgb", "#rrggbb"), "%s" given. No "#" found.',
                    $entry
                )
            ),
            $strlen !== 4 && $strlen !== 7 => throw new InvalidArgumentException(
                sprintf(
                    'Value should be a valid hex color code("#rgb", "#rrggbb"), "%s" given. Length: %d.',
                    $entry,
                    $strlen
                )
            ),
            default => null,
        };
    }

    /**
     * @throws InvalidArgumentException
     */
    public static function assertIntInRange(int $value, int $min, int $max, ?string $callerMethod = null): void
    {
        match (true) {
            $min > $value || $max < $value => throw new InvalidArgumentException(
                sprintf(
                    'Value should be in range %d..%d, int(%d) given%s.',
                    $min,
                    $max,
                    $value,
                    self::getSeeMethodStr($callerMethod)
                )
            ),
            default => null,
        };
    }

    /**
     * @throws InvalidArgumentException
     */
    public static function assertIntColor(
        int $color,
        StylingMethodOption $styleMode,
        ?string $callerMethod = null
    ): void {
        match (true) {
            0 > $color => throw new InvalidArgumentException(
                sprintf(
                    'Value should be positive integer, %d given%s.',
                    $color,
                    self::getSeeMethodStr($callerMethod)
                )
            ),
            StylingMethodOption::ANSI24->name === $styleMode->name => throw new InvalidArgumentException(
                sprintf(
                    'For %s::%s style mode rendering from int is not allowed%s.',
                    StylingMethodOption::class,
                    StylingMethodOption::ANSI24->name,
                    self::getSeeMethodStr($callerMethod)
                )
            ),
            StylingMethodOption::ANSI8->name === $styleMode->name && 255 < $color => throw new InvalidArgumentException(
                sprintf(
                    'For %s::%s style mode value should be in range 0..255, %d given%s.',
                    StylingMethodOption::class,
                    StylingMethodOption::ANSI8->name,
                    $color,
                    self::getSeeMethodStr($callerMethod)
                )
            ),
            StylingMethodOption::ANSI4->name === $styleMode->name && 16 < $color => throw new InvalidArgumentException(
                sprintf(
                    'For %s::%s style mode value should be in range 0..15, %d given%s.',
                    StylingMethodOption::class,
                    StylingMethodOption::ANSI4->name,
                    $color,
                    self::getSeeMethodStr($callerMethod)
                )
            ),
            default => null,
        };
    }
}
