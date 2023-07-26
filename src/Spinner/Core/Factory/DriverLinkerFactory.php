<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Core\Factory;

use AlecRabbit\Spinner\Core\Contract\IDriverLinker;
use AlecRabbit\Spinner\Core\Contract\ILegacySettingsProvider;
use AlecRabbit\Spinner\Core\Contract\Loop\Contract\ILoop;
use AlecRabbit\Spinner\Core\DriverLinker;
use AlecRabbit\Spinner\Core\Factory\Contract\IDriverLinkerFactory;

final class DriverLinkerFactory implements IDriverLinkerFactory
{
    private static ?IDriverLinker $driverLinker = null;

    public function __construct(
        protected ILoop $loop,
        protected ILegacySettingsProvider $settingsProvider,
    ) {
    }

    public function getDriverLinker(): IDriverLinker
    {
        if (self::$driverLinker === null) {
            self::$driverLinker = $this->createLinker();
        }
        return self::$driverLinker;
    }

    private function createLinker(): IDriverLinker
    {
        return
            new DriverLinker(
                $this->loop,
                $this->settingsProvider->getLegacyDriverSettings()->getOptionLinker(),
            );
    }
}
