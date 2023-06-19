<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Core\Widget;

use AlecRabbit\Spinner\Contract\IFrame;
use AlecRabbit\Spinner\Core\Revolver\Contract\IRevolver;
use AlecRabbit\Spinner\Core\Widget\Contract\IWidgetCompositeBuilder;
use AlecRabbit\Spinner\Core\Widget\Contract\IWidgetComposite;
use LogicException;

final class WidgetCompositeBuilder implements IWidgetCompositeBuilder
{
    private ?IFrame $leadingSpacer = null;
    private ?IFrame $trailingSpacer = null;
    private ?IRevolver $revolver = null;

    public function build(): IWidgetComposite
    {
        $this->validate();

        return new WidgetComposite(
            $this->revolver,
            $this->leadingSpacer,
            $this->trailingSpacer,
        );
    }

    private function validate(): void
    {
        match (true) {
            null === $this->revolver => throw new LogicException('Revolver is not set.'),
            $this->leadingSpacer === null => throw new LogicException('Leading spacer is not set.'),
            $this->trailingSpacer === null => throw new LogicException('Trailing spacer is not set.'),
            default => null,
        };
    }

    public function withWidgetRevolver(IRevolver $revolver): IWidgetCompositeBuilder
    {
        $this->revolver = $revolver;
        return $this;
    }

    public function withLeadingSpacer(?IFrame $frame): IWidgetCompositeBuilder
    {
        $this->leadingSpacer = $frame;
        return $this;
    }

    public function withTrailingSpacer(?IFrame $frame): IWidgetCompositeBuilder
    {
        $this->trailingSpacer = $frame;
        return $this;
    }
}