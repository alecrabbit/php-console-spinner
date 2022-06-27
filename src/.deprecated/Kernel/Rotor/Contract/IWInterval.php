<?php

declare(strict_types=1);
// 08.06.22
namespace AlecRabbit\Spinner\Kernel\Rotor\Contract;

interface IWInterval
{
    public function toSeconds(): float;

    public function smallest(?IWInterval $other): ?IWInterval;
}
