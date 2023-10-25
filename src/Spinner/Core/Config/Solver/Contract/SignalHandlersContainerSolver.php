<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Core\Config\Solver\Contract;

use AlecRabbit\Spinner\Core\Config\Solver\A\ASolver;
use AlecRabbit\Spinner\Core\Contract\IDriver;
use AlecRabbit\Spinner\Core\ISignalHandlersContainer;
use AlecRabbit\Spinner\Core\Loop\Contract\ILoop;
use AlecRabbit\Spinner\Core\SignalHandlersContainer;

final readonly class SignalHandlersContainerSolver extends ASolver implements ISignalHandlersContainerSolver
{
    public function solve(): ISignalHandlersContainer
    {
//        return
//            $this->doSolve(
//                $this->extractOption($this->settingsProvider->getUserSettings()),
//                $this->extractOption($this->settingsProvider->getDetectedSettings()),
//                $this->extractOption($this->settingsProvider->getDefaultSettings()),
//            );
        return
            new SignalHandlersContainer(
                new \ArrayObject([
                    SIGINT => static function (IDriver $driver, ILoop $loop): \Closure {
                        return
                            static function () use ($driver, $loop): void {
                                $driver->interrupt('Interrupted' . PHP_EOL);
                                $loop->stop();
                            };
                    },
                ])
            ); // FIXME (2023-10-25 16:21) [Alec Rabbit]: stub!
    }

//    protected function extractOption(ISettings $settings): ?ISignalHandlersContainer
//    {
//        return $this->extractSettingsElement($settings, ILoopSettings::class)?->getSignalHandlingOption();
//    }
}
