<?php

declare(strict_types=1);


namespace AlecRabbit\Spinner\Core\Contract;

use AlecRabbit\Spinner\Contract\IHasFrame;
use AlecRabbit\Spinner\Contract\IHasInterval;
use AlecRabbit\Spinner\Contract\IObserver;
use AlecRabbit\Spinner\Contract\ISubject;
use AlecRabbit\Spinner\Core\Widget\Contract\IWidgetComposite;
use AlecRabbit\Spinner\Core\Widget\Contract\IWidgetContext;

interface ISpinner extends IObserver,
                           ISubject,
                           IHasInterval,
                           IHasFrame
{
    public function add(IWidgetComposite $element): IWidgetContext;

    public function remove(IWidgetComposite $element): void;
}
