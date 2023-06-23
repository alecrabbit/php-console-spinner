<?php

declare(strict_types=1);


namespace AlecRabbit\Spinner\Core\Widget\Factory\Contract;

use AlecRabbit\Spinner\Core\Settings\Contract\IWidgetSettings;
use AlecRabbit\Spinner\Core\Widget\Contract\IWidgetComposite;

interface IWidgetCompositeFactory extends IWidgetFactory
{
    public function createWidget(IWidgetSettings $widgetSettings): IWidgetComposite;
}
