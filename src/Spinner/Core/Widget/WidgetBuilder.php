<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Core\Widget;

use AlecRabbit\Spinner\Contract\IFrame;
use AlecRabbit\Spinner\Core\Config\Contract\IWidgetConfig;
use AlecRabbit\Spinner\Core\Revolver\Contract\IRevolver;
use AlecRabbit\Spinner\Core\Widget\Contract\IWidgetBuilder;
use AlecRabbit\Spinner\Core\Widget\Contract\IWidgetComposite;
use AlecRabbit\Spinner\Core\Widget\Contract\IWidgetRevolverBuilder;
use LogicException;

final class WidgetBuilder implements IWidgetBuilder
{
    protected ?IWidgetConfig $widgetConfig = null;
    protected ?IFrame $leadingSpacer = null;
    protected ?IFrame $trailingSpacer = null;
    protected ?IRevolver $revolver = null;

    public function __construct(
        protected IWidgetRevolverBuilder $widgetRevolverBuilder,
    ) {
    }


    public function build(): IWidgetComposite
    {
        $this->assert();
        return
            new Widget(
                $this->revolver ?? $this->buildRevolver(),
                $this->leadingSpacer ?? $this->widgetConfig->getLeadingSpacer(),
                $this->trailingSpacer ?? $this->widgetConfig->getTrailingSpacer(),
            );
    }

    protected function assert(): void
    {
        match (true) {
            null === $this->leadingSpacer && null === $this->trailingSpacer && null === $this->widgetConfig =>
            throw new LogicException(
                sprintf('[%s]: Property $widgetConfig is not set.', __CLASS__)
            ),
            default => null,
        };
    }

    protected function buildRevolver(): IRevolver
    {
        return
            $this->widgetRevolverBuilder
                ->withStylePattern($this->widgetConfig->getStylePattern())
                ->withCharPattern($this->widgetConfig->getCharPattern())
                ->build()
        ;
    }

    public function withWidgetRevolver(IRevolver $revolver): IWidgetBuilder
    {
        $this->revolver = $revolver;
        return $this;
    }

    public function withLeadingSpacer(?IFrame $frame): IWidgetBuilder
    {
        $this->leadingSpacer = $frame;
        return $this;
    }

    public function withTrailingSpacer(?IFrame $frame): IWidgetBuilder
    {
        $this->trailingSpacer = $frame;
        return $this;
    }

    public function withWidgetConfig(IWidgetConfig $widgetConfig): IWidgetBuilder
    {
        $this->widgetConfig = $widgetConfig;
        return $this;
    }

}
