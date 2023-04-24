<?php

declare(strict_types=1);
// 24.04.23
namespace AlecRabbit\Spinner\Core\Widget\Contract;

use SplObserver;
use SplSubject;

interface IObserverAndSubject extends SplObserver, SplSubject, IWidgetComposite
{

}
