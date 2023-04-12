<?php

declare(strict_types=1);
// 12.04.23
namespace AlecRabbit\Spinner\Core\Widget\Factory\Contract;

use AlecRabbit\Spinner\Core\Defaults\Contract\IWidgetSettings;
use AlecRabbit\Spinner\Core\Revolver\Contract\IRevolver;

interface IWidgetRevolverFactory
{
    public function createWidgetRevolver(IWidgetSettings $widgetSettings): IRevolver;
}
