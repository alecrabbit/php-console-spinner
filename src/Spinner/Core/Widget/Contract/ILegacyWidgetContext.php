<?php

declare(strict_types=1);

// 19.10.22

namespace AlecRabbit\Spinner\Core\Widget\Contract;

interface ILegacyWidgetContext
{
    public function replaceWidget(IWidgetComposite $widget): void;

    public function getWidget(): IWidgetComposite;
}
