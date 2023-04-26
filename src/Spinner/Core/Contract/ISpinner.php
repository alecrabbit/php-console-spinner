<?php

declare(strict_types=1);

// 09.04.23

namespace AlecRabbit\Spinner\Core\Contract;

use AlecRabbit\Spinner\Contract\IHasInterval;
use AlecRabbit\Spinner\Contract\IFrame;
use AlecRabbit\Spinner\Core\Widget\Contract\ILegacyWidgetComposite;
use AlecRabbit\Spinner\Core\Widget\Contract\ILegacyWidgetContext;

interface ISpinner extends IHasInterval
{
    public function update(?float $dt = null): IFrame;

    public function add(ILegacyWidgetComposite|ILegacyWidgetContext $element): ILegacyWidgetContext;

    public function remove(ILegacyWidgetComposite|ILegacyWidgetContext $element): void;
}
