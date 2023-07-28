<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Core\Config\Factory;

use AlecRabbit\Spinner\Core\Config\Contract\IConfig;

final readonly class ConfigFactory implements \AlecRabbit\Spinner\Core\Config\Contract\Factory\IConfigFactory
{
    public function __construct(
//        protected IAuxConfigFactory $auxConfigFactory,
//        protected ILoopConfigFactory $loopConfigFactory,
//        protected IOutputConfigFactory $outputConfigFactory,
//        protected IDriverConfigFactory $driverConfigFactory,
//        protected IWidgetConfigFactory $widgetConfigFactory,
//        protected IWidgetConfigFactory $rootWidgetConfigFactory,
    ) {
    }


    public function create(): IConfig
    {
        // TODO: Implement create() method.
        throw new \RuntimeException('Not implemented.');
    }
}
