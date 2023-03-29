<?php

declare(strict_types=1);
// 29.03.23
namespace AlecRabbit\Spinner\Core\Defaults;

use AlecRabbit\Spinner\Core\Defaults\Contract\IDriverSettings;

final class DriverSettings implements IDriverSettings
{
    /** @var string */
    final protected const MESSAGE_ON_FINALIZE = PHP_EOL;
    /** @var string */
    final protected const MESSAGE_ON_INTERRUPT = PHP_EOL . 'Interrupted!' . PHP_EOL;

    public function __construct(
        protected string $interruptMessage = self::MESSAGE_ON_INTERRUPT,
        protected string $finalMessage = self::MESSAGE_ON_FINALIZE,
    ) {
    }

    public function getFinalMessage(): string
    {
        return $this->finalMessage;
    }

    public function setFinalMessage(string $finalMessage): IDriverSettings
    {
        $this->finalMessage = $finalMessage;
        return $this;
    }

    public function getInterruptMessage(): string
    {
        return $this->interruptMessage;
    }

    public function setInterruptMessage(string $interruptMessage): IDriverSettings
    {
        $this->interruptMessage = $interruptMessage;
        return $this;
    }
}