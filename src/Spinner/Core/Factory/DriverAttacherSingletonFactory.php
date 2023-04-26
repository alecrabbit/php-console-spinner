<?php

declare(strict_types=1);

// 04.04.23

namespace AlecRabbit\Spinner\Core\Factory;

use AlecRabbit\Spinner\Core\Contract\IDefaultsProvider;
use AlecRabbit\Spinner\Core\Contract\IDriverAttacher;
use AlecRabbit\Spinner\Core\Contract\Loop\Contract\ILoop;
use AlecRabbit\Spinner\Core\DriverAttacher;
use AlecRabbit\Spinner\Core\Factory\Contract\IDriverAttacherSingletonFactory;

final class DriverAttacherSingletonFactory implements IDriverAttacherSingletonFactory
{
    private static ?IDriverAttacher $attacher = null;

    public function __construct(
        protected ILoop $loop,
        protected IDefaultsProvider $defaultsProvider,
    ) {
    }

    public function getAttacher(): IDriverAttacher
    {
        if (self::$attacher === null) {
            self::$attacher = $this->createAttacher();
        }
        return self::$attacher;
    }

    private function createAttacher(): IDriverAttacher
    {
        return new DriverAttacher(
            $this->loop,
            $this->defaultsProvider->getDriverSettings()->getOptionAttacher(),
        );
    }
}
