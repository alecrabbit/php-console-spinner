<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Core\Driver;

use AlecRabbit\Spinner\Contract\IDeltaTimer;
use AlecRabbit\Spinner\Core\Contract\IRenderer;
use AlecRabbit\Spinner\Core\Contract\ISpinner;
use AlecRabbit\Spinner\Core\Output\Contract\ISequenceStateWriter;

final readonly class Renderer implements IRenderer
{
    public function __construct(
        private ISequenceStateWriter $stateWriter,
        private IDeltaTimer $deltaTimer,
    ) {
    }

    public function initialize(): void
    {
        $this->stateWriter->initialize();
    }

    public function render(ISpinner $spinner, ?float $dt = null): void
    {
        $this->stateWriter->write(
            $spinner->getState($dt ?? $this->deltaTimer->getDelta())
        );
    }

    public function finalize(?string $finalMessage = null): void
    {
        $this->stateWriter->finalize($finalMessage);
    }

    public function erase(ISpinner $spinner): void
    {
        $this->stateWriter->erase($spinner->getState());
    }
}
