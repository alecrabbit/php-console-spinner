<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Core\Widget\Contract;

use AlecRabbit\Spinner\Contract\HasInterval;
use AlecRabbit\Spinner\Contract\IFrameUpdatable;

interface IWidgetComposite extends HasInterval, IFrameUpdatable
{
    public function add(IWidgetComposite|IWidgetContext $element): IWidgetContext;

    public function remove(IWidgetComposite|IWidgetContext $element): void;

    public function getContext(): IWidgetContext;

    public function setContext(IWidgetContext $widgetContext): void;

    public function adoptBy(IWidgetComposite $widget): void;

    public function makeOrphan(): void;

    public function updateInterval(): void;
}
