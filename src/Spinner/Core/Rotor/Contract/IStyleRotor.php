<?php

declare(strict_types=1);
// 07.06.22
namespace AlecRabbit\Spinner\Core\Rotor\Contract;

interface IStyleRotor
{
    public function join(string $chars, ?IInterval $interval = null): string;
}
