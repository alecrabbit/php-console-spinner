<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Core\Settings\Contract;

interface IMessages
{
    public function getFinalMessage(): ?string;

    public function getInterruptionMessage(): ?string;
}
