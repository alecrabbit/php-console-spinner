<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Core\Widget\Contract;

use AlecRabbit\Spinner\Contract\IHasInterval;
use AlecRabbit\Spinner\Contract\IFrameUpdatable;

interface IWidgetComposite extends IHasInterval, IFrameUpdatable, IHasWidgetContext
{
    public function add(IWidgetComposite|ILegacyWidgetContext $element): ILegacyWidgetContext;

    public function remove(IWidgetComposite|ILegacyWidgetContext $element): void;

    public function adoptBy(IWidgetComposite $widget): void;

    public function makeOrphan(): void;

    public function updateInterval(): void;
}
