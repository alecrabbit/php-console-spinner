<?php

declare(strict_types=1);
// 17.06.22
namespace AlecRabbit\Spinner\Kernel\Wiggler\Contract;

interface ICycle
{
    public function completed(): bool;
}
