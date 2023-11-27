<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Core\Driver;

use AlecRabbit\Spinner\Contract\IDeltaTimer;
use AlecRabbit\Spinner\Core\Builder\Contract\ISequenceStateBuilder;
use AlecRabbit\Spinner\Core\Contract\IRenderer;
use AlecRabbit\Spinner\Core\Contract\ISequenceState;
use AlecRabbit\Spinner\Core\Contract\ISpinner;
use AlecRabbit\Spinner\Core\Output\Contract\ISequenceStateWriter;

final class Renderer implements IRenderer
{
    private ISequenceState $state;

    public function __construct(
        private readonly ISequenceStateWriter $stateWriter,
        private readonly ISequenceStateBuilder $stateBuilder,
        private readonly IDeltaTimer $deltaTimer,
    ) {
        $this->state = $this->createState();
    }

    private function createState(
        string $sequence = '',
        int $width = 0,
        int $previousWidth = 0
    ): ISequenceState {
        return $this->stateBuilder
            ->withSequence($sequence)
            ->withWidth($width)
            ->withPreviousWidth($previousWidth)
            ->build()
        ;
    }

    public function initialize(): void
    {
        $this->stateWriter->initialize();
    }

    public function render(ISpinner $spinner, ?float $dt = null): void
    {
        $frame =
            $spinner->getFrame(
                $dt ?? $this->deltaTimer->getDelta()
            );

        $this->state = $this->createState(
            $frame->getSequence(),
            $frame->getWidth(),
            $this->state->getWidth(),
        );

        $this->stateWriter->write($this->state);
    }

    public function finalize(?string $finalMessage = null): void
    {
        $this->stateWriter->finalize($finalMessage);
    }

    public function erase(ISpinner $spinner): void
    {
        $this->stateWriter->erase($this->state);
    }
}
