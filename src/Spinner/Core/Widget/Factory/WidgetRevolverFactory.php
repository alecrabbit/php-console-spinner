<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Core\Widget\Factory;

use AlecRabbit\Spinner\Core\Config\Contract\IRevolverConfig;
use AlecRabbit\Spinner\Core\Config\Contract\IWidgetRevolverConfig;
use AlecRabbit\Spinner\Core\Factory\Contract\ICharFrameRevolverFactory;
use AlecRabbit\Spinner\Core\Factory\Contract\IStyleFrameRevolverFactory;
use AlecRabbit\Spinner\Core\Pattern\Factory\Contract\IPatternFactory;
use AlecRabbit\Spinner\Core\Revolver\Contract\IRevolver;
use AlecRabbit\Spinner\Core\Widget\Contract\IWidgetRevolver;
use AlecRabbit\Spinner\Core\Widget\Contract\IWidgetRevolverBuilder;
use AlecRabbit\Spinner\Core\Widget\Factory\Contract\IWidgetRevolverFactory;

final class WidgetRevolverFactory implements IWidgetRevolverFactory
{
    public function __construct(
        protected IWidgetRevolverBuilder $widgetRevolverBuilder,
        protected IStyleFrameRevolverFactory $styleRevolverFactory,
        protected ICharFrameRevolverFactory $charRevolverFactory,
        protected IPatternFactory $patternFactory,
        protected IRevolverConfig $revolverConfig,
    ) {
    }

    public function create(IWidgetRevolverConfig $widgetRevolverConfig): IWidgetRevolver
    {
        return
            $this->widgetRevolverBuilder
                ->withStyleRevolver(
                    $this->styleRevolverFactory
                        ->create(
                            $this->patternFactory->create(
                                $widgetRevolverConfig->getStylePalette()
                            )
                        )
                )
                ->withCharRevolver(
                    $this->charRevolverFactory
                        ->create(
                            $this->patternFactory->create(
                                $widgetRevolverConfig->getCharPalette()
                            )
                        )
                )
                ->withTolerance(
                    $this->revolverConfig->getTolerance()
                )
                ->build()
        ;
    }
}
