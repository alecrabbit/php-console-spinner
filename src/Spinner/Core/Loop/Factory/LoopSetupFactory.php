<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Core\Loop\Factory;

use AlecRabbit\Spinner\Contract\IInvokable;
use AlecRabbit\Spinner\Core\Factory\Contract\ILoopSetupFactory;
use AlecRabbit\Spinner\Core\Feature\Resolver\Contract\IAutoStartResolver;
use AlecRabbit\Spinner\Core\Loop\Contract\ILoopSetup;
use AlecRabbit\Spinner\Core\Loop\LoopSetup;

final readonly class LoopSetupFactory implements ILoopSetupFactory, IInvokable
{
    public function __construct(
        private IAutoStartResolver $autoStartResolver,
    ) {
    }

    public function __invoke(): ILoopSetup
    {
        return $this->create();
    }

    public function create(): ILoopSetup
    {
        return new LoopSetup(
            autoStartResolver: $this->autoStartResolver,
        );
    }
}
