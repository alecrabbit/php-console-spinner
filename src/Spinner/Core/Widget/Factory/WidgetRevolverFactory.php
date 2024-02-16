<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Core\Widget\Factory;

use AlecRabbit\Spinner\Core\Config\Contract\IWidgetRevolverConfig;
use AlecRabbit\Spinner\Core\Contract\IIntervalComparator;
use AlecRabbit\Spinner\Core\Factory\Contract\ICharFrameRevolverFactory;
use AlecRabbit\Spinner\Core\Factory\Contract\IStyleFrameRevolverFactory;
use AlecRabbit\Spinner\Core\Pattern\Factory\Contract\IPatternFactory;
use AlecRabbit\Spinner\Core\Widget\Contract\IWidgetRevolver;
use AlecRabbit\Spinner\Core\Widget\Contract\IWidgetRevolverBuilder;
use AlecRabbit\Spinner\Core\Widget\Factory\Contract\IWidgetRevolverFactory;

final readonly class WidgetRevolverFactory implements IWidgetRevolverFactory
{
    public function __construct(
        protected IWidgetRevolverBuilder $widgetRevolverBuilder,
        protected IStyleFrameRevolverFactory $styleRevolverFactory,
        protected ICharFrameRevolverFactory $charRevolverFactory,
        protected IPatternFactory $patternFactory,
        protected IIntervalComparator $intervalComparator,
    ) {
    }

    private function doCreate(IWidgetRevolverConfig $widgetRevolverConfig): IWidgetRevolver
    {
        $styleRevolver = $this->styleRevolverFactory->create(
            $widgetRevolverConfig->getStylePalette()
        );

        $charRevolver = $this->charRevolverFactory->create(
            $widgetRevolverConfig->getCharPalette()
        );

        return $this->widgetRevolverBuilder
            ->withStyleRevolver($styleRevolver)
            ->withCharRevolver($charRevolver)
            ->withIntervalComparator($this->intervalComparator)
            ->build()
        ;
    }

    public function create(IWidgetRevolverConfig $widgetRevolverConfig): IWidgetRevolver
    {
        return $this->legacyDoCreate($widgetRevolverConfig);
    }

    private function legacyDoCreate(IWidgetRevolverConfig $widgetRevolverConfig): IWidgetRevolver
    {
        return $this->widgetRevolverBuilder
            ->withStyleRevolver(
                $this->styleRevolverFactory
                    ->legacyCreate(
                        $this->patternFactory->create(
                            $widgetRevolverConfig->getStylePalette()
                        )
                    )
            )
            ->withCharRevolver(
                $this->charRevolverFactory
                    ->legacyCreate(
                        $this->patternFactory->create(
                            $widgetRevolverConfig->getCharPalette()
                        )
                    )
            )
            ->withIntervalComparator($this->intervalComparator)
            ->build()
        ;
    }
}
