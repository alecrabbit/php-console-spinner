<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner;

use AlecRabbit\Spinner\Contract\Probe\IStaticProbe;
use AlecRabbit\Spinner\Exception\InvalidArgument;
use Traversable;

use function is_subclass_of;

/**
 * @template-covariant T of IStaticProbe
 */
final class Probes
{
    /**
     * @var array<class-string<IStaticProbe>>
     */
    private static array $probes = [];

    /**
     * @codeCoverageIgnore
     */
    private function __construct()
    {
        // No instances of this class are allowed.
    }

    /**
     * @template TV of T
     *
     * @param array<class-string<TV>> $classes
     *
     * @throws InvalidArgument
     */
    public static function register(string ...$classes): void
    {
        foreach ($classes as $probeClass) {
            self::assertClass($probeClass);
            self::$probes[$probeClass] = $probeClass;
        }
    }

    /**
     * @template TV of T
     *
     * @psalm-param class-string<TV> $class
     *
     * @throws InvalidArgument
     */
    private static function assertClass(string $class): void
    {
        if (!self::isProbeSubclass($class)) {
            throw new InvalidArgument(
                sprintf(
                    'Class "%s" must be a subclass of "%s" interface.',
                    $class,
                    IStaticProbe::class
                )
            );
        }
    }

    /**
     * @template TV of T
     *
     * @psalm-param class-string<TV> $class
     */
    private static function isProbeSubclass(string $class): bool
    {
        return is_subclass_of($class, IStaticProbe::class);
    }

    /**
     * @template TV of T
     *
     * @psalm-param class-string<TV>|null $filterClass
     *
     * @psalm-return ($filterClass is string ? Traversable<TV> : Traversable<T>)
     *
     * @throws InvalidArgument
     */
    public static function load(string $filterClass = null): Traversable
    {
        $probes = array_reverse(self::$probes, true);

        if ($filterClass === null) {
            yield from $probes;
        } else {
            self::assertClass($filterClass);
            /** @var TV $probe */
            foreach ($probes as $probe) {
                if (is_subclass_of($probe, $filterClass)) {
                    yield $probe;
                }
            }
        }
    }

    /**
     * @template TV of T
     *
     * @param array<class-string<TV>> $classes
     *
     * @throws InvalidArgument
     */
    public static function unregister(string ...$classes): void
    {
        foreach ($classes as $probeClass) {
            self::assertClass($probeClass);
            if (isset(self::$probes[$probeClass])) {
                unset(self::$probes[$probeClass]);
            }
        }
    }
}
