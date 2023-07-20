<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner;

use AlecRabbit\Spinner\Contract\IStaticProbe;
use AlecRabbit\Spinner\Exception\InvalidArgumentException;

use function is_subclass_of;

final class Probe
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
     * @param Array<class-string<IStaticProbe>> $probes
     * @throws InvalidArgumentException
     */
    public static function register(string ...$probes): void
    {
        foreach ($probes as $probe) {
            self::assertClass($probe);
            self::$probes[$probe] = $probe;
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
     * @param class-string<IStaticProbe>|null $filterClass
     * @return iterable<class-string<IStaticProbe>>
     * @throws InvalidArgumentException
     */
    public static function load(string $filterClass = null): iterable
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
}
