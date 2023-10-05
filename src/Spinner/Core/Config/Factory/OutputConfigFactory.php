<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Core\Config\Factory;

use AlecRabbit\Spinner\Core\Config\Contract\Builder\IOutputConfigBuilder;
use AlecRabbit\Spinner\Core\Config\Contract\Factory\IOutputConfigFactory;
use AlecRabbit\Spinner\Core\Config\Contract\IOutputConfig;
use AlecRabbit\Spinner\Core\Config\Solver\Contract\ICursorVisibilityModeSolver;
use AlecRabbit\Spinner\Core\Config\Solver\Contract\IStylingMethodModeSolver;

final readonly class OutputConfigFactory implements IOutputConfigFactory
{
    public function __construct(
        protected IStylingMethodModeSolver $stylingMethodModeSolver,
        protected ICursorVisibilityModeSolver $cursorVisibilityModeSolver,
        protected IOutputConfigBuilder $outputConfigBuilder,
    ) {
    }

    public function create(): IOutputConfig
    {
        return
            $this->outputConfigBuilder
                ->withStylingMethodMode(
                    $this->stylingMethodModeSolver->solve(),
                )
                ->withCursorVisibilityMode(
                    $this->cursorVisibilityModeSolver->solve(),
                )
                ->build()
        ;
    }
}
