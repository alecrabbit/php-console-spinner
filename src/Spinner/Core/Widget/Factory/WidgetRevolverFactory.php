<?php

declare(strict_types=1);
// 12.04.23
namespace AlecRabbit\Spinner\Core\Widget\Factory;

use AlecRabbit\Spinner\Core\Defaults\Contract\IWidgetSettings;
use AlecRabbit\Spinner\Core\Factory\Contract\ICharRevolverFactory;
use AlecRabbit\Spinner\Core\Factory\Contract\IStyleRevolverFactory;
use AlecRabbit\Spinner\Core\Revolver\Contract\IFrameRevolver;
use AlecRabbit\Spinner\Core\Revolver\Contract\IRevolver;
use AlecRabbit\Spinner\Core\Widget\Contract\IWidgetRevolverBuilder;
use AlecRabbit\Spinner\Core\Widget\Factory\Contract\IWidgetRevolverFactory;

final class WidgetRevolverFactory implements IWidgetRevolverFactory
{
    public function __construct(
        protected IWidgetRevolverBuilder $widgetRevolverBuilder,
        protected IStyleRevolverFactory $styleRevolverFactory,
        protected ICharRevolverFactory $charRevolverFactory,
    ) {
    }

    public function createWidgetRevolver(IWidgetSettings $widgetSettings): IRevolver
    {
        return
            $this->widgetRevolverBuilder
                ->withStyleRevolver($this->getStyleRevolver($widgetSettings))
                ->withCharRevolver($this->getCharRevolver($widgetSettings))
                ->build()
        ;
    }

    private function getStyleRevolver(IWidgetSettings $widgetSettings): IFrameRevolver
    {
        return
            $this->styleRevolverFactory->createStyleRevolver(
                $widgetSettings->getStylePattern()
            );
    }

    private function getCharRevolver(IWidgetSettings $widgetSettings): IFrameRevolver
    {
        return
            $this->charRevolverFactory->createCharRevolver(
                $widgetSettings->getCharPattern()
            );
    }
}
