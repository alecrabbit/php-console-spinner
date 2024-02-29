<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Core\Config\Factory;

use AlecRabbit\Spinner\Contract\IInvokable;
use AlecRabbit\Spinner\Core\Config\Contract\Builder\ILoopConfigBuilder;
use AlecRabbit\Spinner\Core\Config\Contract\Factory\ILoopConfigFactory;
use AlecRabbit\Spinner\Core\Config\Contract\ILoopConfig;
use AlecRabbit\Spinner\Core\Config\Solver\Contract\IAutoStartModeSolver;
use AlecRabbit\Spinner\Core\Config\Solver\Contract\ISignalHandlersContainerSolver;
use AlecRabbit\Spinner\Core\Config\Solver\Contract\ISignalHandlingModeSolver;

final readonly class LoopConfigFactory implements ILoopConfigFactory, IInvokable
{
    public function __construct(
        protected IAutoStartModeSolver $autoStartModeSolver,
        protected ISignalHandlingModeSolver $signalHandlersModeSolver,
        protected ISignalHandlersContainerSolver $signalHandlersContainerSolver,
        protected ILoopConfigBuilder $loopConfigBuilder,
    ) {
    }

    public function create(): ILoopConfig
    {
        return $this->loopConfigBuilder
            ->withAutoStartMode(
                $this->autoStartModeSolver->solve()
            )
            ->withSignalHandlingMode(
                $this->signalHandlersModeSolver->solve()
            )
            ->withSignalHandlersContainer(
                $this->signalHandlersContainerSolver->solve()
            )
            ->build()
        ;
    }

    public function __invoke(): ILoopConfig
    {
        return $this->create();
    }
}
