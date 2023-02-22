<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Core\Revolver\Contract;

use AlecRabbit\Spinner\Core\Contract\HasInterval;
use AlecRabbit\Spinner\Core\Contract\IInterval;
use AlecRabbit\Spinner\Core\Contract\IUpdatable;

interface IRevolver extends IUpdatable, HasInterval
{
    public function setInterval(IInterval $interval): void;
}
