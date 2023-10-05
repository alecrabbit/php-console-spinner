<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Core\Config\Factory;

use AlecRabbit\Spinner\Core\Config\Contract\Builder\ILoopConfigBuilder;
use AlecRabbit\Spinner\Core\Config\Contract\Factory\ILoopConfigFactory;
use AlecRabbit\Spinner\Core\Config\Contract\ILoopConfig;
use AlecRabbit\Spinner\Core\Config\Solver\Contract\IAutoStartModeSolver;
use AlecRabbit\Spinner\Core\Config\Solver\Contract\ISignalHandlersModeSolver;

final class LoopConfigFactory implements ILoopConfigFactory
{
    public function __construct(
        protected IAutoStartModeSolver $autoStartModeSolver,
        protected ISignalHandlersModeSolver $signalHandlersModeSolver,
        protected ILoopConfigBuilder $loopConfigBuilder,
    ) {
    }

    public function create(): ILoopConfig
    {
        return
            $this->loopConfigBuilder
                ->withAutoStartMode(
                    $this->autoStartModeSolver->solve()
                )
                ->withSignalHandlersMode(
                    $this->signalHandlersModeSolver->solve()
                )
                ->build()
        ;
    }
}
