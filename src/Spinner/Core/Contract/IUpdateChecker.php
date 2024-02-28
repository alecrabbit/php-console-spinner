<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Core\Contract;

interface IUpdateChecker
{
    public function isDue(?float $dt = null): bool;
}
