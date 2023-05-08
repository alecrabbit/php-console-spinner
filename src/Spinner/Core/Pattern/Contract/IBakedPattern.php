<?php

declare(strict_types=1);


namespace AlecRabbit\Spinner\Core\Pattern\Contract;

use AlecRabbit\Spinner\Contract\IInterval;
use AlecRabbit\Spinner\Core\Contract\IFrameCollection;

interface IBakedPattern
{
    public function getFrameCollection(): IFrameCollection;

    public function getInterval(): IInterval;
}
