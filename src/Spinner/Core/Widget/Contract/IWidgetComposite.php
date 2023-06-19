<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Core\Widget\Contract;

use AlecRabbit\Spinner\Contract\IObserver;

interface IWidgetComposite extends IWidget,
                                   IObserver
{
    public function add(IWidget $widget): IWidgetContext;

    public function remove(IWidget $widget): void;
}
