<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Core\Settings\Factory;

use AlecRabbit\Spinner\Contract\Option\AutoStartOption;
use AlecRabbit\Spinner\Contract\Option\LinkerOption;
use AlecRabbit\Spinner\Contract\Option\RunMethodOption;
use AlecRabbit\Spinner\Contract\Option\SignalHandlersOption;
use AlecRabbit\Spinner\Contract\Option\StylingMethodOption;
use AlecRabbit\Spinner\Core\Settings\AuxSettings;
use AlecRabbit\Spinner\Core\Settings\Contract\Factory\IDetectedSettingsFactory;
use AlecRabbit\Spinner\Core\Settings\Contract\ISettings;
use AlecRabbit\Spinner\Core\Settings\DriverSettings;
use AlecRabbit\Spinner\Core\Settings\LoopSettings;
use AlecRabbit\Spinner\Core\Settings\OutputSettings;
use AlecRabbit\Spinner\Core\Settings\Settings;

final class DetectedSettingsFactory implements IDetectedSettingsFactory
{
    public function create(): ISettings
    {
        $settings = new Settings();

        $this->fill($settings);

        return $settings;
    }

    private function fill(ISettings $settings): void
    {
        $runMethodOption = $this->getRunMethodOption();

        $settings->set(
            new AuxSettings(
                runMethodOption: $runMethodOption,
            ),
            new DriverSettings(
                linkerOption: $this->getLinkerOption($runMethodOption),
            ),
            new LoopSettings(
                autoStartOption: $this->getAutoStartOption($runMethodOption),
                signalHandlersOption: $this->getSignalHandlersOption($runMethodOption),
            ),
            new OutputSettings(
                stylingMethodOption: $this->getStylingMethodOption(),
            ),
        );
    }

    private function getRunMethodOption(): RunMethodOption
    {
        // returns
        // RunMethodOption::ASYNC       - if Loop is available,
        // RunMethodOption::SYNCHRONOUS - otherwise
        return
            RunMethodOption::ASYNC; // FIXME (2023-09-29 14:32) [Alec Rabbit]: stub!
    }

    private function getLinkerOption(RunMethodOption $runMethodOption): LinkerOption
    {
        return
            $runMethodOption === RunMethodOption::ASYNC
                ? LinkerOption::ENABLED
                : LinkerOption::DISABLED;
    }

    private function getAutoStartOption(RunMethodOption $runMethodOption): AutoStartOption
    {
        return
            $runMethodOption === RunMethodOption::ASYNC
                ? AutoStartOption::ENABLED
                : AutoStartOption::DISABLED;
    }

    private function getSignalHandlersOption(RunMethodOption $runMethodOption): SignalHandlersOption
    {
        return
            $runMethodOption === RunMethodOption::ASYNC
                ? $this->detectSignalMethodOption()
                : SignalHandlersOption::DISABLED;
    }

    protected function detectSignalMethodOption(): SignalHandlersOption
    {
        return
            SignalHandlersOption::ENABLED; // FIXME (2023-09-29 14:32) [Alec Rabbit]: stub!
    }

    private function getStylingMethodOption(): StylingMethodOption
    {
        return
            StylingMethodOption::ANSI24; // FIXME (2023-09-29 14:32) [Alec Rabbit]: stub!
    }
}
