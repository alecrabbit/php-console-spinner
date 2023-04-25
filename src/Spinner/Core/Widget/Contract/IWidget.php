<?php

declare(strict_types=1);
// 24.04.23
namespace AlecRabbit\Spinner\Core\Widget\Contract;

use AlecRabbit\Spinner\Contract\IComboSubjectObserver;
use AlecRabbit\Spinner\Contract\IFrameUpdatable;
use AlecRabbit\Spinner\Contract\IHasInterval;

interface IWidget extends IComboSubjectObserver,
                          IHasInterval,
                          IFrameUpdatable,
                          IHasWidgetContext
{
    public function add(IWidget $widget): IWidgetContext;

    public function remove(IWidget $widget): void;
}
