<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Core\Loop\Contract;

interface ILoopProvider
{
    public function getLoop(): ILoop;

    public function hasLoop(): bool;
}
