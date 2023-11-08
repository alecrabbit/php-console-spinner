<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Core\Output\Contract;

use AlecRabbit\Spinner\Core\Contract\ISequenceState;

interface ISequenceStateWriter
{
    public function finalize(?string $finalMessage = null): void;

    public function initialize(): void;

    public function erase(ISequenceState $state): void;

    public function write(ISequenceState $state): void;
}
