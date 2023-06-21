<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Core\Widget\Contract;

use AlecRabbit\Spinner\Contract\IObserver;
use AlecRabbit\Spinner\Contract\ISubject;

interface IWidgetCompositeChildrenContainer extends ISubject,
                                                    IObserver
{

}
