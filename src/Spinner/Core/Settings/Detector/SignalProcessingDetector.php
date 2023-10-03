<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Core\Settings\Detector;

use AlecRabbit\Spinner\Contract\Probe\ISignalProcessingProbe;
use AlecRabbit\Spinner\Core\Settings\Contract\Detector\ISignalProcessingDetector;
use AlecRabbit\Spinner\Exception\InvalidArgumentException;
use Traversable;

final class SignalProcessingDetector implements ISignalProcessingDetector
{
    public function __construct(
        protected Traversable $probes = new \ArrayObject(),
    ) {
        self::assertProbes($probes);
    }

    private static function assertProbes(Traversable $probes): void
    {
//        foreach ($probes as $probe) {
//            if (!($probe instanceof ISignalProcessingProbe)) {
//                throw new InvalidArgumentException(
//                    sprintf(
//                        'Probe "%s" must be an instance of "%s" interface.',
//                        get_class($probe),
//                        ISignalProcessingProbe::class
//                    )
//                );
//            }
//        }
    }


    /** @inheritDoc */
    public function isSupported(): bool
    {
        foreach ($this->probes as $probe) {
            if ($probe::isSupported()) {
                return true;
            }
        }

        return false;
    }
}
