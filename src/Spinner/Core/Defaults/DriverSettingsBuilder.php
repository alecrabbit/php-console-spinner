<?php
declare(strict_types=1);
// 05.04.23
namespace AlecRabbit\Spinner\Core\Defaults;

use AlecRabbit\Spinner\Core\Defaults\Contract\IDriverSettings;
use AlecRabbit\Spinner\Core\Defaults\Contract\IDriverSettingsBuilder;

final class DriverSettingsBuilder implements IDriverSettingsBuilder
{
    /** @var string */
    final protected const MESSAGE_ON_FINALIZE = PHP_EOL;
    /** @var string */
    final protected const MESSAGE_ON_INTERRUPT = PHP_EOL . 'Interrupted!' . PHP_EOL;

    protected ?string $interruptMessage = null;
    protected ?string $finalMessage = null;

    public function build(): IDriverSettings
    {
        return new DriverSettings(
            interruptMessage: $this->interruptMessage ?? self::MESSAGE_ON_INTERRUPT,
            finalMessage: $this->finalMessage ?? self::MESSAGE_ON_FINALIZE,
        );
    }

    public function withFinalMessage(string $finalMessage): IDriverSettingsBuilder
    {
        $clone = clone $this;
        $clone->finalMessage = $finalMessage;
        return $clone;
    }

    public function withInterruptMessage(string $interruptMessage): IDriverSettingsBuilder
    {
        $clone = clone $this;
        $clone->interruptMessage = $interruptMessage;
        return $clone;
    }
}
