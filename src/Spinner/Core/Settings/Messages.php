<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Core\Settings;

use AlecRabbit\Spinner\Core\Settings\Contract\IMessages;

final readonly class Messages implements IMessages
{
    public function __construct(
        protected ?string $finalMessage = null,
        protected ?string $interruptionMessage = null,
    ) {
    }

    public function getFinalMessage(): ?string
    {
        return $this->finalMessage;
    }

    public function getInterruptionMessage(): ?string
    {
        return $this->interruptionMessage;
    }
}
