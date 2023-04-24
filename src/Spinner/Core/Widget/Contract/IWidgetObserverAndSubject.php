<?php

declare(strict_types=1);
// 24.04.23
namespace AlecRabbit\Spinner\Core\Widget\Contract;

use AlecRabbit\Spinner\Contract\IHasInterval;
use AlecRabbit\Spinner\Contract\IFrameUpdatable;
use SplObserver;
use SplSubject;

interface IWidgetObserverAndSubject extends SplObserver, SplSubject, IHasInterval, IFrameUpdatable, IHasWidgetContext
{
    public function add(IWidgetObserverAndSubject $element): IWidgetContext;

    public function remove(IWidgetObserverAndSubject $element): void;
}
