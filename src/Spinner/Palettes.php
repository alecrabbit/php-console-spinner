<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner;

use AlecRabbit\Spinner\Core\Palette\Contract\IPalette;
use AlecRabbit\Spinner\Exception\InvalidArgumentException;
use Traversable;

use function is_subclass_of;

final class Palettes
{
    /** @var Array<class-string<IPalette>> */
    private static array $palettes = [];

    /**
     * @codeCoverageIgnore
     */
    private function __construct()
    {
        // No instances of this class are allowed.
    }

    /**
     * @param Array<class-string<IPalette>> $classes
     * @throws InvalidArgumentException
     */
    public static function register(string ...$classes): void
    {
        foreach ($classes as $paletteClass) {
            self::assertClass($paletteClass);
            self::$palettes[$paletteClass] = $paletteClass;
        }
    }

    /**
     * @param class-string<IPalette> $class
     * @throws InvalidArgumentException
     */
    private static function assertClass(string $class): void
    {
        if (!self::isSubclass($class)) {
            throw new InvalidArgumentException(
                sprintf(
                    'Class "%s" must implement "%s" interface.',
                    $class,
                    IPalette::class
                )
            );
        }
    }

    /**
     * @param class-string<IPalette> $class
     */
    private static function isSubclass(string $class): bool
    {
        return is_subclass_of($class, IPalette::class);
    }

    /**
     * @template T as IPalette
     * @param class-string<T>|null $filterClass
     * @return Traversable<class-string<T>>
     * @throws InvalidArgumentException
     */
    public static function load(string $filterClass = null): Traversable
    {
        if ($filterClass === null) {
            yield from self::$palettes;
        } else {
            self::assertClass($filterClass);
            foreach (self::$palettes as $palette) {
                if (is_subclass_of($palette, $filterClass)) {
                    yield $palette;
                }
            }
        }
    }

    /**
     * @param class-string<IPalette> $paletteClass
     * @throws InvalidArgumentException
     */
    public static function unregister(string $paletteClass): void
    {
        self::assertClass($paletteClass);
        unset(self::$palettes[$paletteClass]);
    }
}
