<?php

declare(strict_types=1);


namespace AlecRabbit\Spinner\Core\Widget\Contract;

use AlecRabbit\Spinner\Contract\IHasInterval;
use AlecRabbit\Spinner\Contract\IObserver;
use AlecRabbit\Spinner\Contract\ISubject;

interface IWidgetContext extends IObserver,
                                 ISubject,
                                 IHasInterval
{
    public function replaceWidget(IWidget $widget): void;

    public function getWidget(): IWidget;
}
