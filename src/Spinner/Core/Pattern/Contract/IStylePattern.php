<?php

declare(strict_types=1);
// 09.03.23

namespace AlecRabbit\Spinner\Core\Pattern\Contract;

use AlecRabbit\Spinner\Contract\ColorMode;

interface IStylePattern extends IPattern
{
    public function getColorMode(): ColorMode;
}
