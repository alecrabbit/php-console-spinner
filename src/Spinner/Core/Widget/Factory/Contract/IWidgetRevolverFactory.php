<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Core\Widget\Factory\Contract;

use AlecRabbit\Spinner\Core\Config\Contract\IWidgetRevolverConfig;
use AlecRabbit\Spinner\Core\Revolver\Contract\IRevolver;
use AlecRabbit\Spinner\Core\Widget\Contract\IWidgetRevolver;

interface IWidgetRevolverFactory
{
    public function create(IWidgetRevolverConfig $widgetRevolverConfig): IWidgetRevolver;
}
