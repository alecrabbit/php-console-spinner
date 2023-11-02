<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Core\Config\Factory;

use AlecRabbit\Spinner\Core\Config\Config;
use AlecRabbit\Spinner\Core\Config\Contract\Factory\IAuxConfigFactory;
use AlecRabbit\Spinner\Core\Config\Contract\Factory\IConfigFactory;
use AlecRabbit\Spinner\Core\Config\Contract\Factory\IDriverConfigFactory;
use AlecRabbit\Spinner\Core\Config\Contract\Factory\ILinkerConfigFactory;
use AlecRabbit\Spinner\Core\Config\Contract\Factory\ILoopConfigFactory;
use AlecRabbit\Spinner\Core\Config\Contract\Factory\IOutputConfigFactory;
use AlecRabbit\Spinner\Core\Config\Contract\Factory\IRootWidgetConfigFactory;
use AlecRabbit\Spinner\Core\Config\Contract\Factory\IWidgetConfigFactory;
use AlecRabbit\Spinner\Core\Config\Contract\IConfig;

final readonly class ConfigFactory implements IConfigFactory
{
    public function __construct(
        protected IAuxConfigFactory $auxConfigFactory,
        protected IDriverConfigFactory $driverConfigFactory,
        protected ILoopConfigFactory $loopConfigFactory,
        protected IOutputConfigFactory $outputConfigFactory,
        protected ILinkerConfigFactory $linkerConfigFactory,
        protected IWidgetConfigFactory $widgetConfigFactory,
        protected IRootWidgetConfigFactory $rootWidgetConfigFactory,
    ) {
    }

    public function create(): IConfig
    {
        $config = new Config();

        $this->fill($config);

        return
            $config;
    }

    private function fill(IConfig $config): void
    {
        $config->set(
            $this->auxConfigFactory->create(),
            $this->driverConfigFactory->create(),
            $this->loopConfigFactory->create(),
            $this->outputConfigFactory->create(),
            $this->linkerConfigFactory->create(),
            $this->widgetConfigFactory->create(),
            $this->rootWidgetConfigFactory->create(),
        );
    }


}
