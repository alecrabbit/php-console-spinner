<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Core\Config\Factory;

use AlecRabbit\Spinner\Core\Config\Contract\Factory\IConfigFactory;
use AlecRabbit\Spinner\Core\Config\Contract\IConfig;
use RuntimeException;

final readonly class ConfigFactory implements IConfigFactory
{
    public function __construct(
//        protected IAuxConfigFactory $auxConfigFactory,
//        protected ILoopConfigFactory $loopConfigFactory,
//        protected IOutputConfigFactory $outputConfigFactory,
//        protected IDriverConfigFactory $driverConfigFactory,
//        protected IWidgetConfigFactory $widgetConfigFactory,
//        protected IWidgetConfigFactory $rootWidgetConfigFactory,
    )
    {
    }


    public function create(): IConfig
    {
        // TODO: Implement create() method.
        throw new RuntimeException('Not implemented.');
    }
}
