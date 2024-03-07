<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Core\Settings\Factory;

use AlecRabbit\Spinner\Contract\Option\AutoStartOption;
use AlecRabbit\Spinner\Contract\Option\LinkerOption;
use AlecRabbit\Spinner\Contract\Option\ExecutionModeOption;
use AlecRabbit\Spinner\Contract\Option\SignalHandlingOption;
use AlecRabbit\Spinner\Contract\Option\StylingMethodOption;
use AlecRabbit\Spinner\Core\Contract\IDriver;
use AlecRabbit\Spinner\Core\Loop\Contract\ILoop;
use AlecRabbit\Spinner\Core\Settings\Contract\Detector\ILoopSupportDetector;
use AlecRabbit\Spinner\Core\Settings\Contract\Detector\ISignalHandlingSupportDetector;
use AlecRabbit\Spinner\Core\Settings\Contract\Detector\IStylingMethodDetector;
use AlecRabbit\Spinner\Core\Settings\Contract\Factory\IDetectedSettingsFactory;
use AlecRabbit\Spinner\Core\Settings\Contract\IHandlerCreator;
use AlecRabbit\Spinner\Core\Settings\Contract\ISettings;
use AlecRabbit\Spinner\Core\Settings\GeneralSettings;
use AlecRabbit\Spinner\Core\Settings\LinkerSettings;
use AlecRabbit\Spinner\Core\Settings\LoopSettings;
use AlecRabbit\Spinner\Core\Settings\OutputSettings;
use AlecRabbit\Spinner\Core\Settings\Settings;
use AlecRabbit\Spinner\Core\Settings\SignalHandlerCreator;
use AlecRabbit\Spinner\Core\Settings\SignalHandlerSettings;
use Closure;

final readonly class DetectedSettingsFactory implements IDetectedSettingsFactory
{
    public function __construct(
        private ILoopSupportDetector $loopSupportDetector,
        private IStylingMethodDetector $colorSupportDetector,
        private ISignalHandlingSupportDetector $signalProcessingSupportDetector,
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
            new GeneralSettings(
                runMethodOption: $this->getExecutionModeOption(),
            ),
            new LinkerSettings(
                linkerOption: $this->getLinkerOption(),
            ),
            new LoopSettings(
                autoStartOption: $this->getAutoStartOption(),
                signalHandlingOption: $this->getSignalMethodOption(),
            ),
            new OutputSettings(
                stylingMethodOption: $this->detectStylingMethodOption(),
            ),
        );
        if ($this->isSignalHandlingEnabled()) {
            $settings->set(
                new SignalHandlerSettings(
                    new SignalHandlerCreator(
                        signal: SIGINT, // requires pcntl-ext
                        handlerCreator: new class() implements IHandlerCreator {
                            /**
                             * @codeCoverageIgnore
                             */
                            public function createHandler(IDriver $driver, ILoop $loop): Closure
                            {
                                return static function () use ($driver, $loop): void {
                                    $driver->interrupt();
                                    $loop->stop();
                                };
                            }
                        },
                    ),
                ),
            );
        }
    }

    private function getExecutionModeOption(): ExecutionModeOption
    {
        return $this->loopIsAvailable()
            ? ExecutionModeOption::ASYNC
            : ExecutionModeOption::SYNCHRONOUS;
    }

    private function loopIsAvailable(): bool
    {
        return $this->loopSupportDetector->getSupportValue();
    }

    private function getLinkerOption(): LinkerOption
    {
        return $this->loopIsAvailable()
            ? LinkerOption::ENABLED
            : LinkerOption::DISABLED;
    }

    private function getAutoStartOption(): AutoStartOption
    {
        return $this->loopIsAvailable()
            ? AutoStartOption::ENABLED
            : AutoStartOption::DISABLED;
    }

    private function getSignalMethodOption(): SignalHandlingOption
    {
        return $this->signalProcessingSupportDetector->getSupportValue();
    }

    private function detectStylingMethodOption(): StylingMethodOption
    {
        return $this->colorSupportDetector->getSupportValue();
    }

    private function isSignalHandlingEnabled(): bool
    {
        return $this->getSignalMethodOption() === SignalHandlingOption::ENABLED;
    }
}
