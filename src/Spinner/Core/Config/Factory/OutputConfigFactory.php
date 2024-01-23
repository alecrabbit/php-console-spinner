<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Core\Config\Factory;

use AlecRabbit\Spinner\Core\Config\Contract\Builder\IOutputConfigBuilder;
use AlecRabbit\Spinner\Core\Config\Contract\Factory\IOutputConfigFactory;
use AlecRabbit\Spinner\Core\Config\Contract\IOutputConfig;
use AlecRabbit\Spinner\Core\Config\Solver\Contract\ICursorVisibilityModeSolver;
use AlecRabbit\Spinner\Core\Config\Solver\Contract\IInitializationModeSolver;
use AlecRabbit\Spinner\Core\Config\Solver\Contract\IStreamSolver;
use AlecRabbit\Spinner\Core\Config\Solver\Contract\IStylingMethodModeSolver;

final readonly class OutputConfigFactory implements IOutputConfigFactory
{
    public function __construct(
        private IStylingMethodModeSolver $stylingMethodModeSolver,
        private ICursorVisibilityModeSolver $cursorVisibilityModeSolver,
        private IInitializationModeSolver $initializationModeSolver,
        private IStreamSolver $streamSolver,
        private IOutputConfigBuilder $outputConfigBuilder,
    ) {
    }

    public function create(): IOutputConfig
    {
        return $this->outputConfigBuilder
            ->withStylingMethodMode(
                $this->stylingMethodModeSolver->solve(),
            )
            ->withCursorVisibilityMode(
                $this->cursorVisibilityModeSolver->solve(),
            )
            ->withInitializationMode(
                $this->initializationModeSolver->solve(),
            )
            ->withStream(
                $this->streamSolver->solve(),
            )
            ->build()
        ;
    }
}
