<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Core\Factory;

use AlecRabbit\Spinner\Contract\IInvokable;
use AlecRabbit\Spinner\Contract\Probe\IStylingMethodProbe;
use AlecRabbit\Spinner\Core\Factory\Contract\IStylingMethodDetectorFactory;
use AlecRabbit\Spinner\Core\Settings\Contract\Detector\IStylingMethodDetector;
use AlecRabbit\Spinner\Core\Settings\Detector\StylingMethodDetector;
use AlecRabbit\Spinner\Probes;

final readonly class StylingMethodDetectorFactory implements IStylingMethodDetectorFactory, IInvokable
{
    public function __invoke(): IStylingMethodDetector
    {
        return new StylingMethodDetector(
            $this->loadProbes()
        );
    }

    private function loadProbes(): \Traversable
    {
        return Probes::load(IStylingMethodProbe::class);
    }
}
