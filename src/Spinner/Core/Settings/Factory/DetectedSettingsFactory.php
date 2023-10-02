<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Core\Settings\Factory;

use AlecRabbit\Spinner\Contract\Option\AutoStartOption;
use AlecRabbit\Spinner\Contract\Option\LinkerOption;
use AlecRabbit\Spinner\Contract\Option\RunMethodOption;
use AlecRabbit\Spinner\Contract\Option\SignalHandlersOption;
use AlecRabbit\Spinner\Contract\Option\StylingMethodOption;
use AlecRabbit\Spinner\Core\Settings\AuxSettings;
use AlecRabbit\Spinner\Core\Settings\Contract\Detector\ILoopAvailabilityDetector;
use AlecRabbit\Spinner\Core\Settings\Contract\Factory\IDetectedSettingsFactory;
use AlecRabbit\Spinner\Core\Settings\Contract\ISettings;
use AlecRabbit\Spinner\Core\Settings\DriverSettings;
use AlecRabbit\Spinner\Core\Settings\LoopSettings;
use AlecRabbit\Spinner\Core\Settings\OutputSettings;
use AlecRabbit\Spinner\Core\Settings\Settings;

final class DetectedSettingsFactory implements IDetectedSettingsFactory
{
    public function __construct(
        protected ILoopAvailabilityDetector $loopAvailabilityDetector,
    ) {
    }

    public function create(): ISettings
    {
        $settings = new Settings();

        $this->fill($settings);

        return $settings;
    }

    private function fill(ISettings $settings): void
    {
        $settings->set(
            new AuxSettings(
                runMethodOption: $this->getRunMethodOption(),
            ),
            new DriverSettings(
                linkerOption: $this->getLinkerOption(),
            ),
            new LoopSettings(
                autoStartOption: $this->getAutoStartOption(),
                signalHandlersOption: $this->detectSignalMethodOption(),
            ),
            new OutputSettings(
                stylingMethodOption: $this->detectStylingMethodOption(),
            ),
        );
    }

    private function getRunMethodOption(): RunMethodOption
    {
        return
            $this->loopIsAvailable()
                ? RunMethodOption::ASYNC
                : RunMethodOption::SYNCHRONOUS;
    }

    private function loopIsAvailable(): bool
    {
        return $this->loopAvailabilityDetector->loopIsAvailable();
    }

    private function getLinkerOption(): LinkerOption
    {
        return
            $this->loopIsAvailable()
                ? LinkerOption::ENABLED
                : LinkerOption::DISABLED;
    }

    private function getAutoStartOption(): AutoStartOption
    {
        return
            $this->loopIsAvailable()
                ? AutoStartOption::ENABLED
                : AutoStartOption::DISABLED;
    }

    protected function detectSignalMethodOption(): SignalHandlersOption
    {
        // returns detected signal handlers option (using pcntl probe?)
        return
            SignalHandlersOption::ENABLED; // FIXME (2023-09-29 14:32) [Alec Rabbit]: stub!
    }

    private function detectStylingMethodOption(): StylingMethodOption
    {
        // returns detected color support option (using terminal probe?)
        return
            StylingMethodOption::ANSI24; // FIXME (2023-09-29 14:32) [Alec Rabbit]: stub!
    }
}
