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
     * @var array<string, class-string<IStaticProbe>>
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
     * @template TProbe of T
     *
     * @param array<class-string<TProbe>> $classes
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
     * @template TProbe of T
     *
     * @psalm-param class-string<TProbe>|null $class
     *
     * @throws InvalidArgument
     */
    private static function assertClass(?string $class): void
    {
        if ($class === IStaticProbe::class || $class === null) {
            return;
        }
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
     * @template TProbe of T
     *
     * @psalm-param class-string<TProbe> $class
     */
    private static function isProbeSubclass(string $class): bool
    {
        return is_subclass_of($class, IStaticProbe::class);
    }

    /**
     * Loads all registered probes matching filter. If filter is not specified, all registered probes will be loaded.
     * Note that the order of loading is reversed.
     *
     *
     * @template TProbe of T
     *
     * @psalm-param class-string<TProbe>|null $filter
     *
     * @psalm-return ($filter is null ? Traversable<class-string<T>>: Traversable<class-string<TProbe>>)
     *
     * @throws InvalidArgument
     */
    public static function load(?string $filter = null): Traversable
    {
        self::assertClass($filter);

        /** @var class-string<TProbe> $probe */
        foreach (self::reversedProbes() as $probe) {
            if (self::matchesFilter($filter, $probe)) {
                yield $probe;
            }
        }
    }

    /**
     * @return iterable<string, class-string<IStaticProbe>>
     */
    private static function reversedProbes(): iterable
    {
        return array_reverse(self::$probes, true);
    }

    /**
     * @psalm-param class-string<IStaticProbe>|null $filter
     * @psalm-param class-string<IStaticProbe> $probe
     */
    private static function matchesFilter(?string $filter, string $probe): bool
    {
        return $filter === null || is_subclass_of($probe, $filter);
    }

    /**
     * Unregister a probe(s) by class name(s). If interface is passed, all probes implementing this interface will be
     * unregistered.
     *
     * @template TProbe of T
     *
     * @param array<class-string<TProbe>> $classes
     *
     * @throws InvalidArgument
     */
    public static function unregister(string ...$classes): void
    {
        foreach ($classes as $probeClass) {
            self::assertClass($probeClass);

            if (self::isInterface($probeClass)) {
                self::unsetAll(filter: $probeClass);
            }

            self::unsetOne($probeClass);
        }
    }

    private static function isInterface(string $probeClass): bool
    {
        return interface_exists($probeClass);
    }

    /**
     * @psalm-param class-string<IStaticProbe>|null $filter
     */
    private static function unsetAll(?string $filter = null): void
    {
        foreach (self::$probes as $probe) {
            if (self::matchesFilter($filter, $probe)) {
                self::unsetOne($probe);
            }
        }
    }

    /**
     * @psalm-param class-string<IStaticProbe> $probe
     */
    private static function unsetOne(string $probe): void
    {
        if (isset(self::$probes[$probe])) {
            unset(self::$probes[$probe]);
        }
    }
}
