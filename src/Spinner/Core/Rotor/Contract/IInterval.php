<?php

declare(strict_types=1);
// 08.06.22
namespace AlecRabbit\Spinner\Core\Rotor\Contract;

interface IInterval
{
    public function toSeconds(): float;
}
