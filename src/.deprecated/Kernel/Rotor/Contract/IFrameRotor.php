<?php

declare(strict_types=1);
// 07.06.22
namespace AlecRabbit\Spinner\Kernel\Rotor\Contract;

interface IFrameRotor extends IRotor
{
    public function getWidth(): int;
}