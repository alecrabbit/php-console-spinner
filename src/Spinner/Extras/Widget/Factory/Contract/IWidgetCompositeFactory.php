<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Extras\Widget\Factory\Contract;

use AlecRabbit\Spinner\Core\Config\Contract\IWidgetConfig;
use AlecRabbit\Spinner\Core\Settings\Contract\IWidgetSettings;
use AlecRabbit\Spinner\Core\Widget\Contract\IWidgetComposite;
use AlecRabbit\Spinner\Core\Widget\Factory\Contract\IWidgetFactory;

interface IWidgetCompositeFactory extends IWidgetFactory
{
    public function create(IWidgetConfig|IWidgetSettings|null $widgetSettings = null): IWidgetComposite;
}
