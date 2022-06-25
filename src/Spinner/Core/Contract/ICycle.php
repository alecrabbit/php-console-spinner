<?php

declare(strict_types=1);
// 17.06.22
namespace AlecRabbit\Spinner\Core\Contract;

interface ICycle
{
    public function completed(): bool;
}
