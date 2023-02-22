<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Core\Widget\Contract;

use AlecRabbit\Spinner\Core\Contract\HasInterval;
use AlecRabbit\Spinner\Core\Contract\IUpdatable;

interface IWidgetComposite extends HasInterval, IUpdatable
{
    public function add(IWidgetComposite|IWidgetContext $element): IWidgetContext;

    public function remove(IWidgetComposite|IWidgetContext $element): void;

    public function getContext(): IWidgetContext;

    public function setContext(IWidgetContext $widgetContext): void;
}
