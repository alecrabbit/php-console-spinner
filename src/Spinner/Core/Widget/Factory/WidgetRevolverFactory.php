<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Core\Widget\Factory;

use AlecRabbit\Spinner\Core\Config\Contract\IWidgetRevolverConfig;
use AlecRabbit\Spinner\Core\Contract\IIntervalComparator;
use AlecRabbit\Spinner\Core\Pattern\Factory\Contract\ICharPatternFactory;
use AlecRabbit\Spinner\Core\Pattern\Factory\Contract\IStylePatternFactory;
use AlecRabbit\Spinner\Core\Widget\Contract\INeoWidgetRevolverBuilder;
use AlecRabbit\Spinner\Core\Widget\Contract\IWidgetRevolver;

final readonly class WidgetRevolverFactory implements Contract\IWidgetRevolverFactory
{
    public function __construct(
        private INeoWidgetRevolverBuilder $builder,
        private IStylePatternFactory $styleFactory,
        private ICharPatternFactory $charFactory,
        private IIntervalComparator $intervalComparator,
    ) {
    }

    public function create(IWidgetRevolverConfig $widgetRevolverConfig): IWidgetRevolver
    {
        $style = $this->styleFactory->create($widgetRevolverConfig->getStylePalette());
        $char = $this->charFactory->create($widgetRevolverConfig->getCharPalette());

        $interval = $this->intervalComparator->smallest(
            $style->getInterval(),
            $char->getInterval()
        );

        return $this->builder
            ->withStyle($style)
            ->withChar($char)
            ->withInterval($interval)
            ->build()
        ;
    }
}
