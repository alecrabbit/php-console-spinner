<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Core\Contract;

use Stringable;

interface ICharFrame
{
    public function getChar(): string;

    public function getWidth(): int;
}
