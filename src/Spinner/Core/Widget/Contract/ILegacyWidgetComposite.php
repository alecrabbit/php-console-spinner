<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Core\Widget\Contract;

use AlecRabbit\Spinner\Contract\IHasInterval;
use AlecRabbit\Spinner\Contract\IFrameUpdatable;

interface ILegacyWidgetComposite extends IHasInterval, IFrameUpdatable, IHasLegacyWidgetContext
{
    public function add(ILegacyWidgetComposite|ILegacyWidgetContext $element): ILegacyWidgetContext;

    public function remove(ILegacyWidgetComposite|ILegacyWidgetContext $element): void;

    public function adoptBy(ILegacyWidgetComposite $widget): void;

    public function makeOrphan(): void;

    public function updateInterval(): void;
}
