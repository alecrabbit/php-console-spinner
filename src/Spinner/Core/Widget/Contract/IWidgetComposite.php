<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Core\Widget\Contract;

use AlecRabbit\Spinner\Contract\IObserver;

interface IWidgetComposite extends IWidget,
                                   IObserver
{
    public function add(IWidgetComposite $widget): IWidgetContext;

    public function remove(IWidgetComposite $widget): void;
}
