<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Contract;

interface IOutput
{
    public function write(string|iterable $messages): void;
}
