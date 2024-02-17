<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Core\Contract;

use AlecRabbit\Spinner\Contract\IHasInterval;
use AlecRabbit\Spinner\Contract\IHasSequenceFrame;
use AlecRabbit\Spinner\Contract\IObserver;
use AlecRabbit\Spinner\Contract\ISubject;
use AlecRabbit\Spinner\Core\Widget\Contract\IWidgetContext;

interface ISpinner extends IObserver,
                           ISubject,
                           IHasInterval,
                           IHasSequenceFrame
{
    public function add(IWidgetContext $element): IWidgetContext;

    public function remove(IWidgetContext $element): void;
}
