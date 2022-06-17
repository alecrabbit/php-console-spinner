<?php

declare(strict_types=1);
// 17.06.22
namespace AlecRabbit\Spinner\Core\Wiggler\Contract;

interface ICycle
{
    public function completed(): bool;
}
