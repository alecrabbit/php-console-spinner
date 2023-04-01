<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Contract;

interface ISequencer
{
    public function colorSequence(string $sequence): string;
}
