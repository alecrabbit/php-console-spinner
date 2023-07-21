<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner;

use AlecRabbit\Spinner\Contract\IStaticProbe;
use AlecRabbit\Spinner\Exception\InvalidArgumentException;
use Traversable;

use function is_subclass_of;

final class Probes
{
    /** @var Array<class-string<IStaticProbe>> */
    private static array $probes = [];

    /**
     * @codeCoverageIgnore
     */
    private function __construct()
    {
        // No instances of this class are allowed.
    }

    /**
     * @param Array<class-string<IStaticProbe>> $classes
     * @throws InvalidArgumentException
     */
    public static function register(string ...$classes): void
    {
        foreach ($classes as $probeClass) {
            self::assertClass($probeClass);
            self::$probes[$probeClass] = $probeClass;
        }
    }

    /**
     * @param class-string<IStaticProbe> $class
     */
    private static function assertClass(string $class): void
    {
        if (!self::isSubclass($class)) {
            throw new InvalidArgumentException(
                sprintf(
                    'Class "%s" must implement "%s" interface.',
                    $class,
                    IStaticProbe::class
                )
            );
        }
    }

    /**
     * @param class-string<IStaticProbe> $class
     */
    private static function isSubclass(string $class): bool
    {
        return is_subclass_of($class, IStaticProbe::class);
    }

    /**
     * @template T as IStaticProbe
     * @param class-string<T>|null $filterClass
     * @return Traversable<class-string<T>>
     * @throws InvalidArgumentException
     */
    public static function load(string $filterClass = null): Traversable
    {
        if ($filterClass === null) {
            yield from self::$probes;
        } else {
            self::assertClass($filterClass);
            foreach (self::$probes as $probe) {
                if (is_subclass_of($probe, $filterClass)) {
                    yield $probe;
                }
            }
        }
    }

    /**
     * @param class-string<IStaticProbe> $probeClass
     * @throws InvalidArgumentException
     */
    public static function unregister(string $probeClass): void
    {
        self::assertClass($probeClass);
        unset(self::$probes[$probeClass]);
    }
}
