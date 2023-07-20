<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner;

use AlecRabbit\Spinner\Contract\IStaticProbe;
use AlecRabbit\Spinner\Exception\InvalidArgumentException;

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
     * @param class-string<IStaticProbe> $probe
     * @throws InvalidArgumentException
     */
    public static function register(string $probe): void
    {
        self::assertProbeClass($probe);
        self::$probes[$probe] = $probe;
    }

    private static function assertProbeClass(string $probe): void
    {
        if (!\is_subclass_of($probe, IStaticProbe::class)) {
            throw new InvalidArgumentException(
                sprintf(
                    'Class "%s" must implement "%s" interface.',
                    $probe,
                    IStaticProbe::class
                )
            );
        }
    }

    /**
     * @return iterable<class-string<IStaticProbe>>
     */
    public static function load(): iterable
    {
        yield from self::$probes;
    }
}
