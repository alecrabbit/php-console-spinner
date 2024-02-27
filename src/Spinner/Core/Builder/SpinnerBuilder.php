<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Core\Builder;

use AlecRabbit\Spinner\Contract\IObserver;
use AlecRabbit\Spinner\Core\Builder\Contract\ISequenceStateBuilder;
use AlecRabbit\Spinner\Core\Builder\Contract\ISpinnerBuilder;
use AlecRabbit\Spinner\Core\CharSequenceFrame;
use AlecRabbit\Spinner\Core\Contract\ISequenceState;
use AlecRabbit\Spinner\Core\Contract\ISpinner;
use AlecRabbit\Spinner\Core\SequenceState;
use AlecRabbit\Spinner\Core\Spinner;
use AlecRabbit\Spinner\Core\Widget\Contract\IWidget;
use AlecRabbit\Spinner\Exception\LogicException;

final class SpinnerBuilder implements ISpinnerBuilder
{
    private ?IWidget $widget = null;
    private ?IObserver $observer = null;
    private ?ISequenceStateBuilder $stateBuilder = null;
    private ?ISequenceState $initialState = null;

    public function build(): ISpinner
    {
        if ($this->widget === null) {
            throw new LogicException('Widget is not set.');
        }

        if ($this->stateBuilder === null) {
            throw new LogicException('StateBuilder is not set.');
        }

        if ($this->initialState === null) {
            $this->initialState = $this->createInitialState();
        }

        return new Spinner(
            widget: $this->widget,
            stateBuilder: $this->stateBuilder,
            state: $this->initialState,
            observer: $this->observer,
        );
    }

    private function createInitialState(): ISequenceState
    {
        // FIXME (2024-02-27 16:11) [Alec Rabbit]: stub!
        return $this->stateBuilder
            ->withSequenceFrame(new CharSequenceFrame('', 0))
            ->withPrevious(new SequenceState('', 0, 0))
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

    public function withInitialState(ISequenceState $state): ISpinnerBuilder
    {
        $clone = clone $this;
        $clone->initialState = $state;
        return $clone;
    }
}
