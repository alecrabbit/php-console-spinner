<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Core\Settings\Detector;

use AlecRabbit\Spinner\Core\Contract\Loop\Contract\Probe\ILoopProbe;
use AlecRabbit\Spinner\Core\Settings\Contract\Detector\ILoopAvailabilityDetector;
use AlecRabbit\Spinner\Exception\InvalidArgumentException;
use Traversable;

final class LoopAvailabilityDetector implements ILoopAvailabilityDetector
{
    public function __construct(
        protected Traversable $probes = new \ArrayObject(),
    ) {
    }

    /** @inheritDoc */
    public function loopIsAvailable(): bool
    {
        foreach ($this->probes as $probe) {
            self::assertProbe($probe);
            if ($probe::isSupported()) {
                return true;
            }
        }

        return false;
    }

    protected static function assertProbe($probe): void
    {
        if (!is_a($probe, ILoopProbe::class, true)) {
            throw new InvalidArgumentException(
                sprintf(
                    'Probe must be an instance of "%s" interface.',
                    ILoopProbe::class
                )
            );
        }
    }
}
