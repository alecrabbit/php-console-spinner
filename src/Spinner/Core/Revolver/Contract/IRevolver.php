<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Core\Revolver\Contract;

use AlecRabbit\Spinner\I\HasInterval;
use AlecRabbit\Spinner\I\IInterval;
use AlecRabbit\Spinner\I\IUpdatable;

interface IRevolver extends IUpdatable, HasInterval
{
    public function setInterval(IInterval $interval): void;
}
