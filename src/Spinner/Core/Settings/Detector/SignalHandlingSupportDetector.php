<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Core\Settings\Detector;

use AlecRabbit\Spinner\Contract\Option\SignalHandlingOption;
use AlecRabbit\Spinner\Contract\Probe\ISignalHandlingProbe;
use AlecRabbit\Spinner\Core\Settings\Contract\Detector\ISignalHandlingSupportDetector;
use AlecRabbit\Spinner\Exception\InvalidArgumentException;
use ArrayObject;
use Traversable;

final class SignalHandlingSupportDetector implements ISignalHandlingSupportDetector
{
    public function __construct(
        protected Traversable $probes = new ArrayObject(),
    ) {
    }

    public function getSupportValue(): SignalHandlingOption
    {
        foreach ($this->probes as $probe) {
            self::assertProbe($probe);
            if ($probe::isSupported()) {
                $class = $probe::getCreatorClass();
                return (new $class)->create();
            }
        }

        return SignalHandlingOption::DISABLED;
    }

    protected static function assertProbe($probe): void
    {
        if (!is_a($probe, ISignalHandlingProbe::class, true)) {
            throw new InvalidArgumentException(
                sprintf(
                    'Probe must be an instance of "%s" interface.',
                    ISignalHandlingProbe::class
                )
            );
        }
    }
}
