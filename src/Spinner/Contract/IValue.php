<?php

declare(strict_types=1);
// 10.03.23

namespace AlecRabbit\Spinner\Contract;

interface IValue
{
    public function getValue(): mixed;

    public function setValue($value): void;
}
