<?php

declare(strict_types=1);

// 04.04.23

namespace AlecRabbit\Spinner\Core\Factory;

use AlecRabbit\Spinner\Core\Contract\IDefaultsProvider;
use AlecRabbit\Spinner\Core\Contract\IDriverLinker;
use AlecRabbit\Spinner\Core\Contract\Loop\Contract\ILoop;
use AlecRabbit\Spinner\Core\DriverLinker;
use AlecRabbit\Spinner\Core\Factory\Contract\IDriverLinkerSingletonFactory;

final class DriverLinkerSingletonFactory implements IDriverLinkerSingletonFactory
{
    private static ?IDriverLinker $driverLinker = null;

    public function __construct(
        protected ILoop $loop,
        protected IDefaultsProvider $defaultsProvider,
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
        return new DriverLinker(
            $this->loop,
            $this->defaultsProvider->getDriverSettings()->getOptionLinker(),
        );
    }
}
