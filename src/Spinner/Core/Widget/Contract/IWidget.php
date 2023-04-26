<?php

declare(strict_types=1);
// 24.04.23
namespace AlecRabbit\Spinner\Core\Widget\Contract;

use AlecRabbit\Spinner\Contract\IHasFrame;
use AlecRabbit\Spinner\Contract\IHasInterval;
use AlecRabbit\Spinner\Contract\IObserver;
use AlecRabbit\Spinner\Contract\ISubject;

interface IWidget extends IObserver,
                          ISubject,
                          IHasInterval,
                          IHasFrame,
                          IHasWidgetContext
{
    public function add(IWidget $widget): IWidgetContext;

    public function remove(IWidget $widget): void;
}
