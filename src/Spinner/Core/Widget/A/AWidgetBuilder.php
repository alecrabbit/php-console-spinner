<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Core\Widget\A;

use AlecRabbit\Spinner\Contract\IFrame;
use AlecRabbit\Spinner\Core\Defaults\Contract\IDefaults;
use AlecRabbit\Spinner\Core\Revolver\Contract\IRevolver;
use AlecRabbit\Spinner\Core\Widget\Contract\IWidgetBuilder;
use AlecRabbit\Spinner\Core\Widget\Contract\IWidgetComposite;
use AlecRabbit\Spinner\Core\Widget\Contract\IWidgetRevolverBuilder;
use AlecRabbit\Spinner\Core\Widget\Widget;

abstract class AWidgetBuilder implements IWidgetBuilder
{
    protected ?IRevolver $revolver = null;
    protected ?IFrame $leadingSpacer = null;
    protected ?IFrame $trailingSpacer = null;

    public function __construct(
        protected IDefaults $defaults,
        protected IWidgetRevolverBuilder $widgetRevolverBuilder,
    ) {
    }

    /**
     * @inheritdoc
     */
    public function build(): IWidgetComposite
    {
        return
            new Widget(
                $this->revolver ?? $this->widgetRevolverBuilder->build(),
                $this->leadingSpacer ?? $this->defaults->getWidgetSettings()->getLeadingSpacer(),
                $this->trailingSpacer ?? $this->defaults->getWidgetSettings()->getTrailingSpacer(),
            );
    }

    public function withWidgetRevolver(?IRevolver $revolver): static
    {
        $clone = clone $this;
        $clone->revolver = $revolver;
        return $clone;
    }

    public function withLeadingSpacer(?IFrame $frame): static
    {
        $clone = clone $this;
        $clone->leadingSpacer = $frame;
        return $clone;
    }

    public function withTrailingSpacer(?IFrame $frame): static
    {
        $clone = clone $this;
        $clone->trailingSpacer = $frame;
        return $clone;
    }
}
