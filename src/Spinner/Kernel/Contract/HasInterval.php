<?php
declare(strict_types=1);
// 19.06.22
namespace AlecRabbit\Spinner\Kernel\Contract;

use AlecRabbit\Spinner\Kernel\Rotor\Contract\WIInterval;

interface HasInterval
{
    public function getInterval(): WIInterval;
}
