<?php

declare(strict_types=1);
// 24.04.23
namespace AlecRabbit\Spinner\Core\Widget\Contract;

interface IHasWidgetContext
{
    public function getContext(): ILegacyWidgetContext;

    public function setContext(ILegacyWidgetContext $widgetContext): void;
}
