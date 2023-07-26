<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Core\Contract;

use AlecRabbit\Spinner\Contract\IInterval;
use AlecRabbit\Spinner\Contract\IObserver;
use AlecRabbit\Spinner\Contract\ITimer;
use AlecRabbit\Spinner\Core\Output\Contract\IDriverOutput;
use AlecRabbit\Spinner\Core\Settings\Legacy\Contract\ILegacyDriverSettings;

interface IDriverBuilder
{
    public function build(): IDriver;

    public function withInitialInterval(IInterval $interval): IDriverBuilder;

    public function withTimer(ITimer $timer): IDriverBuilder;

    public function withDriverOutput(IDriverOutput $driverOutput): IDriverBuilder;

    public function withObserver(IObserver $observer): IDriverBuilder;

    public function withDriverSettings(ILegacyDriverSettings $driverSettings): IDriverBuilder;
}
