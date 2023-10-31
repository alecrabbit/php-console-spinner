<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner;

use AlecRabbit\Spinner\Contract\Probe\IStaticProbe;
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
     * @psalm-template T as IStaticProbe
     * @psalm-param class-string<T> $class
     * @throws InvalidArgumentException
     */
    private static function assertClass(string $class): void
    {
        if (!self::isSubclass($class)) {
            throw new InvalidArgumentException(
                sprintf(
                    'Class "%s" must be a subclass of "%s" interface.',
                    $class,
                    IStaticProbe::class
                )
            );
        }
    }

    /**
     * @psalm-template T as IStaticProbe
     *
     * @psalm-param class-string<T> $class
     */
    private static function isSubclass(string $class): bool
    {
        return is_subclass_of($class, IStaticProbe::class);
    }

    /**
     * @psalm-template T as IStaticProbe
     *
     * @psalm-param class-string<T>|null $filterClass
     *
     * @psalm-return Traversable<T>|Traversable<IStaticProbe>
     *
     * @throws InvalidArgumentException
     */
    public static function load(string $filterClass = null): Traversable
    {
        $probes = array_reverse(self::$probes, true);

        if ($filterClass === null) {
            yield from $probes;
        } else {
            self::assertClass($filterClass);
            /** @var T $probe */
            foreach ($probes as $probe) {
                if (is_subclass_of($probe, $filterClass)) {
                    yield $probe;
                }
            }
        }
    }

    /**
     * @param Array<class-string<IStaticProbe>> $classes
     * @throws InvalidArgumentException
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
