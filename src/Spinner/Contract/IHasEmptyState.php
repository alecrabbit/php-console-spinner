<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Contract;

interface IHasEmptyState
{
    public function isEmpty(): bool;
}
