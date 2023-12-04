<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Core\Widget\Contract;

use AlecRabbit\Spinner\Contract\IObserver;

interface IWidgetComposite extends IWidget,
                                   IObserver
{
    public function add(IWidgetContext $context): IWidgetContext;

    public function remove(IWidgetContext $context): void;

    public function getContext(): IWidgetContext;
}
