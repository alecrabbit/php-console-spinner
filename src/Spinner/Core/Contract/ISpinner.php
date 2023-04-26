<?php

declare(strict_types=1);

// 09.04.23

namespace AlecRabbit\Spinner\Core\Contract;

use AlecRabbit\Spinner\Contract\IComboSubjectObserver;
use AlecRabbit\Spinner\Contract\IFrameUpdatable;
use AlecRabbit\Spinner\Contract\IHasInterval;
use AlecRabbit\Spinner\Core\Widget\Contract\IWidget;
use AlecRabbit\Spinner\Core\Widget\Contract\IWidgetContext;

interface ISpinner extends IComboSubjectObserver,
                           IHasInterval,
                           IFrameUpdatable
{
    public function add(IWidget $element): IWidgetContext;

    public function remove(IWidget $element): void;
}
