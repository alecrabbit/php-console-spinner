<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Core\Widget\Factory\Contract;

use AlecRabbit\Spinner\Core\Config\Contract\IWidgetRevolverConfig;
use AlecRabbit\Spinner\Core\Revolver\Contract\IRevolver;

interface IWidgetRevolverFactory
{
    public function create(IWidgetRevolverConfig $widgetRevolverConfig): IRevolver;
}
