<?php

declare(strict_types=1);
// 12.04.23
namespace AlecRabbit\Spinner\Core\Widget\Factory;

use AlecRabbit\Spinner\Core\Revolver\Contract\IFrameRevolverBuilder;
use AlecRabbit\Spinner\Core\Revolver\Contract\IRevolver;
use AlecRabbit\Spinner\Core\Widget\Contract\IWidgetRevolverBuilder;
use AlecRabbit\Spinner\Core\Widget\Factory\Contract\IWidgetRevolverFactory;

final class WidgetRevolverFactory implements IWidgetRevolverFactory
{
    public function __construct(
        protected IWidgetRevolverBuilder $widgetRevolverBuilder,
        protected IFrameRevolverBuilder $frameRevolverBuilder,
    ) {
    }

    public function createWidgetRevolver(): IRevolver
    {
        return
            $this
                ->widgetRevolverBuilder
                ->build()
        ;
    }
}
