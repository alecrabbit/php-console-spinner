<?php

declare(strict_types=1);
// 08.06.22
namespace AlecRabbit\Spinner\Kernel\Rotor\Contract;

interface WIInterval
{
    public function toSeconds(): float;

    public function smallest(?WIInterval $other): ?WIInterval;
}
