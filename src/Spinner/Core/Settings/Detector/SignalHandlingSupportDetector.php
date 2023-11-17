<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Core\Settings\Detector;

use AlecRabbit\Spinner\Contract\Option\SignalHandlingOption;
use AlecRabbit\Spinner\Contract\Probe\ISignalHandlingOptionCreator;
use AlecRabbit\Spinner\Contract\Probe\ISignalHandlingProbe;
use AlecRabbit\Spinner\Core\Settings\Contract\Detector\ISignalHandlingSupportDetector;
use AlecRabbit\Spinner\Exception\InvalidArgument;
use ArrayObject;
use Traversable;

final readonly class SignalHandlingSupportDetector implements ISignalHandlingSupportDetector
{
    public function __construct(
        protected Traversable $probes = new ArrayObject(),
    ) {
    }

    public function getSupportValue(): SignalHandlingOption
    {
        /** @var class-string<ISignalHandlingProbe> $probe */
        foreach ($this->probes as $probe) {
            self::assertProbe($probe);
            if ($probe::isSupported()) {
                /** @var class-string<ISignalHandlingOptionCreator> $class */
                $class = $probe::getCreatorClass();
                return (new $class())->create();
            }
        }

        return SignalHandlingOption::DISABLED;
    }

    private static function assertProbe(mixed $probe): void
    {
        if (!is_a($probe, ISignalHandlingProbe::class, true)) {
            throw new InvalidArgument(
                sprintf(
                    'Probe must be an instance of "%s" interface.',
                    ISignalHandlingProbe::class
                )
            );
        }
    }
}
