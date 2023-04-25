<?php

declare(strict_types=1);

// 09.04.23

namespace AlecRabbit\Spinner\Core\Contract;

use AlecRabbit\Spinner\Contract\IHasInterval;
use AlecRabbit\Spinner\Contract\IFrame;
use AlecRabbit\Spinner\Core\Widget\Contract\IWidgetComposite;
use AlecRabbit\Spinner\Core\Widget\Contract\ILegacyWidgetContext;

interface ISpinner extends IHasInterval
{
    public function update(?float $dt = null): IFrame;

    public function add(IWidgetComposite|ILegacyWidgetContext $element): ILegacyWidgetContext;

    public function remove(IWidgetComposite|ILegacyWidgetContext $element): void;
}
