<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Core\Driver\Factory;

use AlecRabbit\Spinner\Container\Contract\IInvokable;
use AlecRabbit\Spinner\Core\Contract\IDriverLinker;
use AlecRabbit\Spinner\Core\Driver\DriverLinker;
use AlecRabbit\Spinner\Core\Driver\DummyDriverLinker;
use AlecRabbit\Spinner\Core\Factory\Contract\IDriverLinkerFactory;
use AlecRabbit\Spinner\Core\Feature\Resolver\Contract\ILinkerResolver;
use AlecRabbit\Spinner\Core\Loop\Contract\ILoopProvider;

final readonly class DriverLinkerFactory implements IDriverLinkerFactory, IInvokable
{
    public function __construct(
        private ILoopProvider $loopProvider,
        private ILinkerResolver $linkerResolver,
    ) {
    }

    public function create(): IDriverLinker
    {
        if ($this->isLinkerEnabled()) {
            return new DriverLinker(
                loop: $this->loopProvider->getLoop(),
            );
        }

        return new DummyDriverLinker();
    }

    private function isLinkerEnabled(): bool
    {
        return $this->loopProvider->hasLoop() && $this->linkerResolver->isEnabled();
    }

    public function __invoke(): IDriverLinker
    {
        return $this->create();
    }
}
