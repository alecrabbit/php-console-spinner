<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Core\Factory;

use AlecRabbit\Spinner\Core\Config\Contract\IDriverConfig;
use AlecRabbit\Spinner\Core\Contract\IDriverLinker;
use AlecRabbit\Spinner\Core\Contract\Loop\ILoop;
use AlecRabbit\Spinner\Core\DriverLinker;
use AlecRabbit\Spinner\Core\Factory\Contract\IDriverLinkerFactory;

final class DriverLinkerFactory implements IDriverLinkerFactory
{
    public function __construct(
        protected ILoop $loop,
        protected IDriverConfig $driverConfig,
    ) {
    }

    public function create(): IDriverLinker
    {
        return
            new DriverLinker(
                $this->loop,
                $this->driverConfig->getLinkerMode(),
            );
    }
}
