<?php

declare(strict_types=1);

// 09.04.23

namespace AlecRabbit\Spinner\Core\Contract;

use AlecRabbit\Spinner\Contract\IHasInterval;
use AlecRabbit\Spinner\Contract\IFrame;
use AlecRabbit\Spinner\Core\Widget\Contract\IWidget;
use AlecRabbit\Spinner\Core\Widget\Contract\IWidgetContext;

interface ISpinner extends IHasInterval
{
    public function update(?float $dt = null): IFrame;

    public function add(IWidget $element): IWidgetContext;

    public function remove(IWidget $element): void;
}
