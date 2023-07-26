<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Core\Widget\Factory\Contract;

use AlecRabbit\Spinner\Core\Settings\Legacy\Contract\ILegacyWidgetSettings;
use AlecRabbit\Spinner\Core\Widget\Contract\IWidgetComposite;

interface IWidgetCompositeFactory extends IWidgetFactory
{
    public function createWidget(ILegacyWidgetSettings $widgetSettings): IWidgetComposite;
}
