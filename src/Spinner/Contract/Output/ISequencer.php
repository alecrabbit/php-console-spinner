<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Contract\Output;

interface ISequencer
{
    public function colorSequence(string $sequence): string;
}
