<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Core\Widget\Factory;

use AlecRabbit\Spinner\Core\Config\Contract\IWidgetRevolverConfig;
use AlecRabbit\Spinner\Core\Contract\ITolerance;
use AlecRabbit\Spinner\Core\Factory\Contract\ICharFrameRevolverFactory;
use AlecRabbit\Spinner\Core\Factory\Contract\IStyleFrameRevolverFactory;
use AlecRabbit\Spinner\Core\Revolver\Contract\IFrameRevolver;
use AlecRabbit\Spinner\Core\Revolver\Contract\IRevolver;
use AlecRabbit\Spinner\Core\Revolver\Tolerance;
use AlecRabbit\Spinner\Core\Settings\Legacy\Contract\ILegacyWidgetSettings;
use AlecRabbit\Spinner\Core\Widget\Contract\IWidgetRevolver;
use AlecRabbit\Spinner\Core\Widget\Contract\IWidgetRevolverBuilder;
use AlecRabbit\Spinner\Core\Widget\Factory\Contract\IWidgetRevolverFactory;
use RuntimeException;

final class WidgetRevolverFactory implements IWidgetRevolverFactory
{
    public function __construct(
        protected IWidgetRevolverBuilder $widgetRevolverBuilder,
        protected IStyleFrameRevolverFactory $styleRevolverFactory,
        protected ICharFrameRevolverFactory $charRevolverFactory,
    ) {
    }

    public function legacyCreateWidgetRevolver(ILegacyWidgetSettings $widgetSettings): IWidgetRevolver
    {
        return
            $this->widgetRevolverBuilder
                ->withStyleRevolver(
                    $this->getStyleRevolver($widgetSettings)
                )
                ->withCharRevolver(
                    $this->getCharRevolver($widgetSettings)
                )
                ->withTolerance(
                    $this->getTolerance()
                )
                ->build()
        ;
    }

    private function getStyleRevolver(ILegacyWidgetSettings $widgetSettings): IFrameRevolver
    {
        return
            $this->styleRevolverFactory
                ->createStyleRevolver(
                    $widgetSettings->getStylePattern()
                )
        ;
    }

    private function getCharRevolver(ILegacyWidgetSettings $widgetSettings): IFrameRevolver
    {
        return
            $this->charRevolverFactory
                ->createCharRevolver(
                    $widgetSettings->getCharPattern()
                )
        ;
    }

    private function getTolerance(): ITolerance
    {
        // TODO (2023-04-26 14:21) [Alec Rabbit]: make it configurable [fd86d318-9069-47e2-b60d-a68f537be4a3]
        return new Tolerance();
    }

    public function create(IWidgetRevolverConfig $revolverConfig): IRevolver
    {
        // TODO: Implement create() method.
        throw new RuntimeException('Not implemented.');

//        return
//            $this->widgetRevolverBuilder
//                ->withStyleRevolver(
//                    $this->styleRevolverFactory
//                        ->createStyleRevolver(
//                            $revolverConfig->getStylePalette()
//                        )
//                )
//                ->withCharRevolver(
//                    $this->charRevolverFactory
//                        ->createCharRevolver(
//                             $revolverConfig->getCharPalette()
//                        )
//                )
//                ->withTolerance(
//                    $this->getTolerance()
//                )
//                ->build()
//        ;
    }
}
