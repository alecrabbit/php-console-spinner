<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Core\Widget\Contract;

interface IWidgetComposite extends IWidget
{
    public function add(IWidgetComposite $widget): IWidgetContext;

    public function remove(IWidgetComposite $widget): void;
}
