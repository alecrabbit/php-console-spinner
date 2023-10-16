<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Core\Config\Factory;

use AlecRabbit\Spinner\Core\Config\Contract\Builder\ILoopConfigBuilder;
use AlecRabbit\Spinner\Core\Config\Contract\Factory\ILoopConfigFactory;
use AlecRabbit\Spinner\Core\Config\Contract\ILoopConfig;
use AlecRabbit\Spinner\Core\Config\Solver\Contract\IAutoStartModeSolver;
use AlecRabbit\Spinner\Core\Config\Solver\Contract\ISignalHandlingModeSolver;

final class LoopConfigFactory implements ILoopConfigFactory
{
    public function __construct(
        protected IAutoStartModeSolver $autoStartModeSolver,
        protected ISignalHandlingModeSolver $signalHandlersModeSolver,
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
                ->withSignalHandlingMode(
                    $this->signalHandlersModeSolver->solve()
                )
                ->build()
        ;
    }
}
