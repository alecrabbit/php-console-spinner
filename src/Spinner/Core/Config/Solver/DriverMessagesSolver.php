<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Core\Config\Solver;

use AlecRabbit\Spinner\Core\Config\Solver\A\ASolver;
use AlecRabbit\Spinner\Core\Config\Solver\Contract\IDriverMessagesSolver;
use AlecRabbit\Spinner\Core\Contract\IDriverMessages;
use AlecRabbit\Spinner\Core\DriverMessages;
use AlecRabbit\Spinner\Core\Settings\Contract\IDriverSettings;
use AlecRabbit\Spinner\Core\Settings\Contract\IMessages;
use AlecRabbit\Spinner\Core\Settings\Contract\ISettings;
use AlecRabbit\Spinner\Exception\LogicException;

final readonly class DriverMessagesSolver extends ASolver implements IDriverMessagesSolver
{
    public function solve(): IDriverMessages
    {
        return $this->doSolve(
            $this->extractMessages($this->settingsProvider->getUserSettings()),
            $this->extractMessages($this->settingsProvider->getDetectedSettings()),
            $this->extractMessages($this->settingsProvider->getDefaultSettings()),
        );
    }

    private function doSolve(
        ?IMessages $userMessages,
        ?IMessages $detectedMessages,
        ?IMessages $defaultMessages,
    ): IDriverMessages {
        $finalMessage =
            $userMessages?->getFinalMessage()
            ?? $detectedMessages?->getFinalMessage()
            ?? $defaultMessages?->getFinalMessage()
            ?? throw new LogicException(
                sprintf('Unable to solve "%s". (for final message)', IDriverMessages::class)
            );

        $interruptionMessage =
            $userMessages?->getInterruptionMessage()
            ?? $detectedMessages?->getInterruptionMessage()
            ?? $defaultMessages?->getInterruptionMessage()
            ?? throw new LogicException(
                sprintf('Unable to solve "%s". (for interrupt message)', IDriverMessages::class)
            );

        return new DriverMessages(
            finalMessage: $finalMessage,
            interruptionMessage: $interruptionMessage,
        );
    }

    private function extractMessages(ISettings $settings): ?IMessages
    {
        return $this->extractSettingsElement($settings, IDriverSettings::class)?->getMessages();
    }
}
