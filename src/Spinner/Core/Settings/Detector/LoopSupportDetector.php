<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Core\Settings\Detector;

use AlecRabbit\Spinner\Core\Contract\Loop\ILoopProbe;
use AlecRabbit\Spinner\Core\Settings\Contract\Detector\ILoopSupportDetector;
use AlecRabbit\Spinner\Exception\InvalidArgumentException;
use ArrayObject;
use Traversable;

final class LoopSupportDetector implements ILoopSupportDetector
{
    public function __construct(
        protected Traversable $probes = new ArrayObject(),
    ) {
    }

    /** @inheritDoc */
    public function isSupported(): bool
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
