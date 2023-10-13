<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Core\Settings\Detector;

use AlecRabbit\Spinner\Contract\Probe\ISignalProcessingProbe;
use AlecRabbit\Spinner\Core\Settings\Contract\Detector\ISignalProcessingSupportDetector;
use AlecRabbit\Spinner\Exception\InvalidArgumentException;
use ArrayObject;
use Traversable;

final class SignalProcessingSupportDetector implements ISignalProcessingSupportDetector
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
        if (!is_a($probe, ISignalProcessingProbe::class, true)) {
            throw new InvalidArgumentException(
                sprintf(
                    'Probe must be an instance of "%s" interface.',
                    ISignalProcessingProbe::class
                )
            );
        }
    }
}