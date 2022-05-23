<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Core\Contract;

interface IWiggler
{
    public function getSequence(float|int|null $interval = null): string;

    public function getWidth(): int;
}
