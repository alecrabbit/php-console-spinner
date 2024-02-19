<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Core\Widget\Factory;

use AlecRabbit\Spinner\Core\Config\Contract\IWidgetRevolverConfig;
use AlecRabbit\Spinner\Core\Widget\Contract\INeoWidgetRevolverBuilder;
use AlecRabbit\Spinner\Core\Widget\Contract\IWidgetRevolver;

final readonly class NeoWidgetRevolverFactory implements Contract\IWidgetRevolverFactory
{
    public function __construct(
        private INeoWidgetRevolverBuilder $builder,
    )
    {
    }

    public function create(IWidgetRevolverConfig $widgetRevolverConfig): IWidgetRevolver
    {
        // TODO: Implement create() method.
        throw new \RuntimeException(__METHOD__ . ' Not implemented.');
    }
}
