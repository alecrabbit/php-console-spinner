<?php

declare(strict_types=1);


namespace AlecRabbit\Spinner\Core\Widget\Factory\Contract;

use AlecRabbit\Spinner\Core\Revolver\Contract\IRevolver;
use AlecRabbit\Spinner\Core\Settings\Contract\ILegacyWidgetSettings;

interface IWidgetRevolverFactory
{
    public function createWidgetRevolver(ILegacyWidgetSettings $widgetSettings): IRevolver;
}
