<?php

declare(strict_types=1);
// 17.03.23
namespace AlecRabbit\Spinner\Core\Config;

use AlecRabbit\Spinner\Core\Config\Contract\IDriverConfig;

final class DriverConfig implements IDriverConfig
{
    public function __construct(
        protected string $interruptMessage,
        protected string $finalMessage,
    ) {
    }

    public function getInterruptMessage(): string
    {
        return $this->interruptMessage;
    }

    public function getFinalMessage(): string
    {
        return $this->finalMessage;
    }
}