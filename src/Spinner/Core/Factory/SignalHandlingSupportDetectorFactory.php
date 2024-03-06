<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Core\Factory;

use AlecRabbit\Spinner\Contract\IInvokable;
use AlecRabbit\Spinner\Contract\Probe\ISignalHandlingProbe;
use AlecRabbit\Spinner\Core\Contract\IProbesLoader;
use AlecRabbit\Spinner\Core\Factory\Contract\ISignalHandlingSupportDetectorFactory;
use AlecRabbit\Spinner\Core\Settings\Contract\Detector\ISignalHandlingSupportDetector;
use AlecRabbit\Spinner\Core\Settings\Detector\SignalHandlingSupportDetector;

final readonly class SignalHandlingSupportDetectorFactory implements ISignalHandlingSupportDetectorFactory, IInvokable
{
    public function __construct(
        private IProbesLoader $probesLoader,
    ) {
    }

    public function __invoke(): ISignalHandlingSupportDetector
    {
        return new SignalHandlingSupportDetector(
            $this->probesLoader->load(ISignalHandlingProbe::class)
        );
    }
}
