<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Core;

use AlecRabbit\Spinner\Core\Contract\IDriverMessages;

final readonly class DriverMessages implements IDriverMessages
{
    public function __construct(
        private string $finalMessage,
        private string $interruptionMessage,
    ) {
    }

    public function getFinalMessage(): string
    {
        return $this->finalMessage;
    }

    public function getInterruptionMessage(): string
    {
        return $this->interruptionMessage;
    }
}
