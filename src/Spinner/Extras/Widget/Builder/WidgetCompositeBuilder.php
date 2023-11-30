<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Extras\Widget\Builder;

use AlecRabbit\Spinner\Contract\IFrame;
use AlecRabbit\Spinner\Core\Contract\IIntervalComparator;
use AlecRabbit\Spinner\Core\Widget\Builder\A\AWidgetBuilder;
use AlecRabbit\Spinner\Core\Widget\Contract\IWidgetComposite;
use AlecRabbit\Spinner\Core\Widget\Contract\IWidgetRevolver;
use AlecRabbit\Spinner\Exception\LogicException;
use AlecRabbit\Spinner\Extras\Widget\Builder\Contract\IWidgetCompositeBuilder;
use AlecRabbit\Spinner\Extras\Widget\WidgetComposite;

/**
 * @psalm-suppress PossiblyNullArgument
 */
final class WidgetCompositeBuilder extends AWidgetBuilder implements IWidgetCompositeBuilder
{
    private ?IIntervalComparator $intervalComparator = null;

    public function build(): IWidgetComposite
    {
        $this->validate();

        return new WidgetComposite(
            revolver: $this->revolver,
            leadingSpacer: $this->leadingSpacer,
            trailingSpacer: $this->trailingSpacer,
            intervalComparator: $this->intervalComparator,
        );
    }

    protected function validate(): void
    {
        parent::validate();

        match (true) {
            $this->intervalComparator === null => throw new LogicException('Interval comparator is not set.'),
            default => null,
        };
    }

    public function withWidgetRevolver(IWidgetRevolver $revolver): IWidgetCompositeBuilder
    {
        $clone = clone $this;
        $clone->revolver = $revolver;
        return $clone;
    }

    public function withLeadingSpacer(IFrame $leadingSpacer): IWidgetCompositeBuilder
    {
        $clone = clone $this;
        $clone->leadingSpacer = $leadingSpacer;
        return $clone;
    }

    public function withTrailingSpacer(IFrame $trailingSpacer): IWidgetCompositeBuilder
    {
        $clone = clone $this;
        $clone->trailingSpacer = $trailingSpacer;
        return $clone;
    }

    public function withIntervalComparator(IIntervalComparator $intervalComparator): IWidgetCompositeBuilder
    {
        $clone = clone $this;
        $clone->intervalComparator = $intervalComparator;
        return $clone;
    }
}
