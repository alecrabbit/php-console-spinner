<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Core\Widget\Factory;

use AlecRabbit\Spinner\Core\Config\Contract\IWidgetRevolverConfig;
use AlecRabbit\Spinner\Core\Contract\IIntervalComparator;
use AlecRabbit\Spinner\Core\Factory\Contract\ICharFrameRevolverFactory;
use AlecRabbit\Spinner\Core\Factory\Contract\IStyleFrameRevolverFactory;
use AlecRabbit\Spinner\Core\Widget\Contract\IWidgetRevolver;
use AlecRabbit\Spinner\Core\Widget\Contract\IWidgetRevolverBuilder;
use AlecRabbit\Spinner\Core\Widget\Factory\Contract\IWidgetRevolverFactory;

final readonly class WidgetRevolverFactory implements IWidgetRevolverFactory
{
    public function __construct(
        private IWidgetRevolverBuilder $widgetRevolverBuilder,
        private IStyleFrameRevolverFactory $styleRevolverFactory,
        private ICharFrameRevolverFactory $charRevolverFactory,
        private IIntervalComparator $intervalComparator,
    ) {
    }

    public function create(IWidgetRevolverConfig $widgetRevolverConfig): IWidgetRevolver
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
}
