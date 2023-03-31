<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Core;

use AlecRabbit\Spinner\Contract\IFrame;
use AlecRabbit\Spinner\Core\A\ABuilder;
use AlecRabbit\Spinner\Core\Config\Contract\IWidgetConfig;
use AlecRabbit\Spinner\Core\Revolver\Contract\IRevolver;
use AlecRabbit\Spinner\Core\Widget\Contract\IWidgetBuilder;
use AlecRabbit\Spinner\Core\Widget\Contract\IWidgetComposite;
use AlecRabbit\Spinner\Core\Widget\Contract\IWidgetRevolverBuilder;
use AlecRabbit\Spinner\Core\Widget\Widget;
use LogicException;

final class WidgetBuilder extends ABuilder implements IWidgetBuilder
{
    protected ?IWidgetConfig $widgetConfig = null;
    protected ?IFrame $leadingSpacer = null;
    protected ?IFrame $trailingSpacer = null;
    protected ?IRevolver $revolver = null;

    public function build(): IWidgetComposite
    {
        $this->assert();
        return
            new Widget(
                $this->createRevolver(),
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

    protected function createRevolver(): IRevolver
    {
        return $this->revolver ?? $this->buildRevolver();
    }

    protected function buildRevolver(): IRevolver
    {
        return $this->getWidgetRevolverBuilder()
            ->withStyleRevolver(
                $this->getRevolverFactory()
                    ->create(
                        $this->widgetConfig->getStylePattern()
                    )
            )
            ->withCharRevolver(
                $this->getRevolverFactory()
                    ->create(
                        $this->widgetConfig->getCharPattern()
                    )
            )
            ->build()
        ;
    }

    private function getWidgetRevolverBuilder(): IWidgetRevolverBuilder
    {
        return $this->container->get(IWidgetRevolverBuilder::class);
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
