<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Contract;

interface IHasSequence
{
    public function getSequence(): string;
}
