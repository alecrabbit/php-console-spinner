<?php

declare(strict_types=1);

// 09.04.23

namespace AlecRabbit\Spinner\Core\Contract;

use AlecRabbit\Spinner\Contract\IHasFrame;
use AlecRabbit\Spinner\Contract\IHasInterval;
use AlecRabbit\Spinner\Contract\IObserver;
use AlecRabbit\Spinner\Contract\ISubject;
use AlecRabbit\Spinner\Core\Widget\Contract\IWidget;
use AlecRabbit\Spinner\Core\Widget\Contract\IWidgetContext;

interface ISpinner extends IObserver,
                           ISubject,
                           IHasInterval,
                           IHasFrame
{
    public function add(IWidget $element): IWidgetContext;

    public function remove(IWidget $element): void;
}
