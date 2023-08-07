<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Core\Config\Factory;

use AlecRabbit\Spinner\Core\Config\Config;
use AlecRabbit\Spinner\Core\Config\Contract\Factory\IAuxConfigFactory;
use AlecRabbit\Spinner\Core\Config\Contract\Factory\IConfigFactory;
use AlecRabbit\Spinner\Core\Config\Contract\Factory\IDriverConfigFactory;
use AlecRabbit\Spinner\Core\Config\Contract\Factory\ILoopConfigFactory;
use AlecRabbit\Spinner\Core\Config\Contract\Factory\IOutputConfigFactory;
use AlecRabbit\Spinner\Core\Config\Contract\Factory\IRootWidgetConfigFactory;
use AlecRabbit\Spinner\Core\Config\Contract\Factory\IWidgetConfigFactory;
use AlecRabbit\Spinner\Core\Config\Contract\IConfig;

final readonly class ConfigFactory implements IConfigFactory
{
    public function __construct(
        protected IAuxConfigFactory $auxConfigFactory,
        protected ILoopConfigFactory $loopConfigFactory,
        protected IOutputConfigFactory $outputConfigFactory,
        protected IDriverConfigFactory $driverConfigFactory,
        protected IWidgetConfigFactory $widgetConfigFactory,
        protected IRootWidgetConfigFactory $rootWidgetConfigFactory,
    ) {
    }

    public function create(): IConfig
    {
        return
            new Config(
                $this->auxConfigFactory->create(),
                $this->loopConfigFactory->create(),
                $this->outputConfigFactory->create(),
                $this->driverConfigFactory->create(),
                $this->widgetConfigFactory->create(),
                $this->rootWidgetConfigFactory->create(),
            );
    }
}
