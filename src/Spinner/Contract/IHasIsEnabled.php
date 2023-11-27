<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Contract;

interface IHasIsEnabled
{
    public function isEnabled(): bool;
}
