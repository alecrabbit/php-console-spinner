<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Contract;

interface IFinalizable
{
    public function finalize(?string $finalMessage = null): void;
}
