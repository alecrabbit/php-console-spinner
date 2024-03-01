<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Core\Factory;

use AlecRabbit\Spinner\Contract\IInvokable;
use AlecRabbit\Spinner\Core\Factory\Contract\ILoopSupportDetectorFactory;
use AlecRabbit\Spinner\Core\Loop\Contract\ILoopCreatorClassProvider;
use AlecRabbit\Spinner\Core\Settings\Contract\Detector\ILoopSupportDetector;
use AlecRabbit\Spinner\Core\Settings\Detector\LoopSupportDetector;

final readonly class LoopSupportDetectorFactory implements ILoopSupportDetectorFactory, IInvokable
{
    public function __construct(
        private ILoopCreatorClassProvider $loopCreatorClassProvider,
    ) {
    }

    public function __invoke(): ILoopSupportDetector
    {
        return new LoopSupportDetector(
            $this->loopCreatorClassProvider->getCreatorClass(),
        );
    }
}
