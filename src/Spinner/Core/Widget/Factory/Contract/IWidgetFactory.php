<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Core\Widget\Factory\Contract;

use AlecRabbit\Spinner\Core\Settings\Contract\IWidgetSettings;
use AlecRabbit\Spinner\Core\Settings\Legacy\Contract\ILegacyWidgetSettings;
use AlecRabbit\Spinner\Core\Widget\Contract\IWidget;

interface IWidgetFactory
{
    public function legacyCreateWidget(ILegacyWidgetSettings $widgetSettings): IWidget;

    public function create(?IWidgetSettings $widgetSettings = null): IWidget;
}
