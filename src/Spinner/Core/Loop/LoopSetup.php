<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Core\Loop;

use AlecRabbit\Spinner\Core\Feature\Resolver\Contract\IAutoStartResolver;
use AlecRabbit\Spinner\Core\Loop\Contract\ILoop;
use AlecRabbit\Spinner\Core\Loop\Contract\ILoopSetup;

final readonly class LoopSetup implements ILoopSetup
{
    public function __construct(
        private IAutoStartResolver $autoStartResolver,
    ) {
    }

    public function setup(ILoop $loop): void
    {
        if ($this->autoStartResolver->isEnabled()) {
            $loop->autoStart();
        }
    }
}
