<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Core\Builder;

use AlecRabbit\Spinner\Contract\IObserver;
use AlecRabbit\Spinner\Core\Builder\Contract\ISpinnerBuilder;
use AlecRabbit\Spinner\Core\Contract\ISpinner;
use AlecRabbit\Spinner\Core\Spinner;
use AlecRabbit\Spinner\Core\Widget\Contract\IWidget;
use AlecRabbit\Spinner\Exception\LogicException;

final class SpinnerBuilder implements ISpinnerBuilder
{
    private ?IWidget $widget = null;
    private ?IObserver $observer = null;

    public function build(): ISpinner
    {
        if ($this->widget === null) {
            throw new LogicException('Widget is not set.');
        }

        return new Spinner(
            widget: $this->widget,
            observer: $this->observer,
        );
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
}
