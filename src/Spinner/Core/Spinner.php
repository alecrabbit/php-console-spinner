<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Core;

use AlecRabbit\Spinner\Contract\IInterval;
use AlecRabbit\Spinner\Contract\IObserver;
use AlecRabbit\Spinner\Contract\ISequenceFrame;
use AlecRabbit\Spinner\Contract\ISubject;
use AlecRabbit\Spinner\Core\A\ASubject;
use AlecRabbit\Spinner\Core\Builder\Contract\ISequenceStateBuilder;
use AlecRabbit\Spinner\Core\Contract\ISequenceState;
use AlecRabbit\Spinner\Core\Contract\ISpinner;
use AlecRabbit\Spinner\Core\Widget\Contract\IWidget;

final class Spinner extends ASubject implements ISpinner
{
    public function __construct(
        private readonly IWidget $widget,
        private readonly ISequenceStateBuilder $stateBuilder,
        private ISequenceState $state,
        ?IObserver $observer = null,
    ) {
        parent::__construct($observer);
        $this->widget->attach($this);
    }

    public function getInterval(): IInterval
    {
        return $this->widget->getInterval();
    }

    public function update(ISubject $subject): void
    {
        if ($subject === $this->widget) {
            $this->notify();
        }
    }

    public function getState(?float $dt = null): ISequenceState
    {
        if ($dt !== null) {
            $frame = $this->getFrame($dt);

            $this->state = $this->stateBuilder
                ->withSequence($frame->getSequence())
                ->withWidth($frame->getWidth())
                ->withPreviousWidth($this->state->getWidth())
                ->build()
            ;
        }

        return $this->state;
    }

    public function getFrame(?float $dt = null): ISequenceFrame
    {
        return $this->widget->getFrame($dt);
    }
}
