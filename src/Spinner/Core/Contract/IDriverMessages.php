<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Core\Contract;

interface IDriverMessages
{
    public function getFinalMessage(): string;

    public function getInterruptionMessage(): string;
}
