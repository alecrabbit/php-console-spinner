<?php

declare(strict_types=1);
// 07.06.22
namespace AlecRabbit\Spinner\Core\Rotor\Contract;

interface IStyleRotor extends IRotor
{
    public function join(string $chars): string;
}
