<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Core;

use AlecRabbit\Spinner\Contract\IInterval;
use AlecRabbit\Spinner\Contract\IObserver;
use AlecRabbit\Spinner\Contract\ISequenceFrame;
use AlecRabbit\Spinner\Contract\ISubject;
use AlecRabbit\Spinner\Core\A\ASubject;
use AlecRabbit\Spinner\Core\Contract\ISequenceState;
use AlecRabbit\Spinner\Core\Contract\ISpinner;
use AlecRabbit\Spinner\Core\Factory\Contract\ISequenceStateFactory;
use AlecRabbit\Spinner\Core\Widget\Contract\IWidget;

final class Spinner extends ASubject implements ISpinner
{
    public function __construct(
        private readonly IWidget $widget,
        private readonly ISequenceStateFactory $stateFactory,
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
            $frame = $this->widget->getFrame($dt);

            $this->state = $this->createState($frame);
        }

        return $this->state;
    }

    private function createState(ISequenceFrame $frame): ISequenceState
    {
        return $this->stateFactory->create($frame, $this->state);
    }
}
