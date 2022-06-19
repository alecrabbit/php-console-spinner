<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Core\Contract;

use Stringable;

interface IFrame extends Stringable
{
    public function getSequence(): string;

    public function getWidth(): int;
}
