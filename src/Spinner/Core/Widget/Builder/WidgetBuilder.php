<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Core\Widget\Builder;

use AlecRabbit\Spinner\Contract\ISequenceFrame;
use AlecRabbit\Spinner\Core\Widget\Builder\A\AWidgetBuilder;
use AlecRabbit\Spinner\Core\Widget\Contract\IWidget;
use AlecRabbit\Spinner\Core\Widget\Contract\IWidgetBuilder;
use AlecRabbit\Spinner\Core\Widget\Contract\IWidgetRevolver;
use AlecRabbit\Spinner\Core\Widget\Widget;

/**
 * @psalm-suppress PossiblyNullArgument
 */
final class WidgetBuilder extends AWidgetBuilder implements IWidgetBuilder
{
    public function build(): IWidget
    {
        $this->validate();

        return new Widget(
            $this->revolver,
            $this->leadingSpacer,
            $this->trailingSpacer,
        );
    }

    public function withWidgetRevolver(IWidgetRevolver $revolver): IWidgetBuilder
    {
        $clone = clone $this;
        $clone->revolver = $revolver;
        return $clone;
    }

    public function withLeadingSpacer(ISequenceFrame $leadingSpacer): IWidgetBuilder
    {
        $clone = clone $this;
        $clone->leadingSpacer = $leadingSpacer;
        return $clone;
    }

    public function withTrailingSpacer(ISequenceFrame $trailingSpacer): IWidgetBuilder
    {
        $clone = clone $this;
        $clone->trailingSpacer = $trailingSpacer;
        return $clone;
    }
}
