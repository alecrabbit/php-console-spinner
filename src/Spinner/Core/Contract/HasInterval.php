<?php
declare(strict_types=1);
// 19.06.22
namespace AlecRabbit\Spinner\Core\Contract;

use AlecRabbit\Spinner\Core\Rotor\Contract\IInterval;

interface HasInterval
{
    public function getInterval(): IInterval;
}
