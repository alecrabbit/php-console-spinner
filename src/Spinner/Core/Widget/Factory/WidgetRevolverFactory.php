<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Core\Widget\Factory;

use AlecRabbit\Spinner\Core\Config\Contract\IWidgetRevolverConfig;
use AlecRabbit\Spinner\Core\Contract\ITolerance;
use AlecRabbit\Spinner\Core\Factory\Contract\ICharFrameRevolverFactory;
use AlecRabbit\Spinner\Core\Factory\Contract\IStyleFrameRevolverFactory;
use AlecRabbit\Spinner\Core\Pattern\Factory\Contract\IPatternFactory;
use AlecRabbit\Spinner\Core\Revolver\Contract\IRevolver;
use AlecRabbit\Spinner\Core\Revolver\Tolerance;
use AlecRabbit\Spinner\Core\Widget\Contract\IWidgetRevolverBuilder;
use AlecRabbit\Spinner\Core\Widget\Factory\Contract\IWidgetRevolverFactory;

final class WidgetRevolverFactory implements IWidgetRevolverFactory
{
    public function __construct(
        protected IWidgetRevolverBuilder $widgetRevolverBuilder,
        protected IStyleFrameRevolverFactory $styleRevolverFactory,
        protected ICharFrameRevolverFactory $charRevolverFactory,
        protected IPatternFactory $patternFactory,
    ) {
    }

    public function create(IWidgetRevolverConfig $revolverConfig): IRevolver
    {
        return
            $this->widgetRevolverBuilder
                ->withStyleRevolver(
                    $this->styleRevolverFactory
                        ->create(
                            $this->patternFactory->create(
                                $revolverConfig->getStylePalette()
                            )
                        )
                )
                ->withCharRevolver(
                    $this->charRevolverFactory
                        ->create(
                            $this->patternFactory->create(
                                $revolverConfig->getCharPalette()
                            )
                        )
                )
                ->withTolerance(
                    $this->getTolerance()
                )
                ->build()
        ;
    }

    private function getTolerance(): ITolerance
    {
        // TODO (2023-04-26 14:21) [Alec Rabbit]: make it configurable [fd86d318-9069-47e2-b60d-a68f537be4a3]
        return new Tolerance();
    }
}
