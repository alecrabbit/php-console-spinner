<?php

declare(strict_types=1);

// 09.04.23

namespace AlecRabbit\Spinner\Core\Contract;

use AlecRabbit\Spinner\Contract\HasInterval;
use AlecRabbit\Spinner\Contract\IFrame;
use AlecRabbit\Spinner\Core\Widget\Contract\IWidgetComposite;
use AlecRabbit\Spinner\Core\Widget\Contract\IWidgetContext;

interface ISpinner extends HasInterval
{
    public function update(?float $dt = null): IFrame;

    public function add(IWidgetComposite|IWidgetContext $element): IWidgetContext;

    public function remove(IWidgetComposite|IWidgetContext $element): void;
}
