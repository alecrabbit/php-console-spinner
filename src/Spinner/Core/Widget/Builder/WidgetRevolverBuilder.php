<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Core\Widget\Builder;

use AlecRabbit\Spinner\Core\Contract\IIntervalComparator;
use AlecRabbit\Spinner\Core\Contract\ITolerance;
use AlecRabbit\Spinner\Core\Revolver\A\ARevolverBuilder;
use AlecRabbit\Spinner\Core\Revolver\Contract\IFrameRevolver;
use AlecRabbit\Spinner\Core\Widget\Contract\IWidgetRevolver;
use AlecRabbit\Spinner\Core\Widget\Contract\IWidgetRevolverBuilder;
use AlecRabbit\Spinner\Core\Widget\WidgetRevolver;
use AlecRabbit\Spinner\Exception\LogicException;

/**
 * @psalm-suppress PossiblyNullArgument
 */
final class WidgetRevolverBuilder extends ARevolverBuilder implements IWidgetRevolverBuilder
{
    private ?IFrameRevolver $styleRevolver = null;
    private ?IFrameRevolver $charRevolver = null;
    private ?IIntervalComparator $intervalComparator = null;

    public function build(): IWidgetRevolver
    {
        $this->validate();

        return new WidgetRevolver(
            $this->styleRevolver,
            $this->charRevolver,
            $this->intervalComparator,
        );
    }

    protected function validate(): void
    {
        match (true) {
            $this->styleRevolver === null => throw new LogicException('Style revolver is not set.'),
            $this->charRevolver === null => throw new LogicException('Character revolver is not set.'),
            $this->intervalComparator === null => throw new LogicException('Interval comparator is not set.'),
            default => null,
        };
    }

    public function withStyleRevolver(IFrameRevolver $styleRevolver): IWidgetRevolverBuilder
    {
        $clone = clone $this;
        $clone->styleRevolver = $styleRevolver;
        return $clone;
    }

    public function withCharRevolver(IFrameRevolver $charRevolver): IWidgetRevolverBuilder
    {
        $clone = clone $this;
        $clone->charRevolver = $charRevolver;
        return $clone;
    }

    public function withIntervalComparator(IIntervalComparator $intervalComparator): IWidgetRevolverBuilder
    {
        $clone = clone $this;
        $clone->intervalComparator = $intervalComparator;
        return $clone;
    }
}
