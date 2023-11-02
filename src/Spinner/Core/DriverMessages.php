<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Core;

use AlecRabbit\Spinner\Core\Contract\IDriverMessages;

final readonly class DriverMessages implements IDriverMessages
{
    public function __construct(
        protected string $finalMessage,
        protected string $interruptionMessage,
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
