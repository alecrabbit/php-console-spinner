<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Core\Builder;

use AlecRabbit\Spinner\Contract\IObserver;
use AlecRabbit\Spinner\Core\Builder\Contract\ISequenceStateBuilder;
use AlecRabbit\Spinner\Core\Builder\Contract\ISpinnerBuilder;
use AlecRabbit\Spinner\Core\Contract\ISequenceState;
use AlecRabbit\Spinner\Core\Contract\ISpinner;
use AlecRabbit\Spinner\Core\Spinner;
use AlecRabbit\Spinner\Core\Widget\Contract\IWidget;
use AlecRabbit\Spinner\Exception\LogicException;

final class SpinnerBuilder implements ISpinnerBuilder
{
    private ?IWidget $widget = null;
    private ?IObserver $observer = null;
    private ?ISequenceStateBuilder $stateBuilder = null;
    private ?ISequenceState $state = null;

    public function build(): ISpinner
    {
        if ($this->widget === null) {
            throw new LogicException('Widget is not set.');
        }

        if ($this->stateBuilder === null) {
            throw new LogicException('StateBuilder is not set.');
        }

        if ($this->state === null) {
            $this->state = $this->createInitialState();
        }

        return new Spinner(
            widget: $this->widget,
            stateBuilder: $this->stateBuilder,
            state: $this->state,
            observer: $this->observer,
        );
    }

    private function createInitialState(): ISequenceState
    {
        return $this->stateBuilder
            ->withSequence('')
            ->withWidth(0)
            ->withPreviousWidth(0)
            ->build()
        ;
    }

    public function withWidget(IWidget $widget): ISpinnerBuilder
    {
        $clone = clone $this;
        $clone->widget = $widget;
        return $clone;
    }

    public function withObserver(IObserver $observer): ISpinnerBuilder
    {
        $clone = clone $this;
        $clone->observer = $observer;
        return $clone;
    }

    public function withStateBuilder(ISequenceStateBuilder $stateBuilder): ISpinnerBuilder
    {
        $clone = clone $this;
        $clone->stateBuilder = $stateBuilder;
        return $clone;
    }
}
