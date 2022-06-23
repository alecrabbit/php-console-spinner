<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Core\Output\Contract;

interface IOutput
{
    public function write(string|iterable $messages, bool $newline = false, int $options = 0): void;

    public function writeln(string|iterable $messages, int $options = 0);
}
