<?php

declare(strict_types=1);
// 07.06.22
namespace AlecRabbit\Spinner\Kernel\Rotor\Contract;

interface IWIPStyleRotor
{
    public function join(string $chars, ?IInterval $interval = null): string;
}
