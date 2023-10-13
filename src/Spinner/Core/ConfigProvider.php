<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Core;

use AlecRabbit\Spinner\Core\Config\Contract\IConfig;
use AlecRabbit\Spinner\Core\Contract\IConfigProvider;

final readonly class ConfigProvider implements IConfigProvider
{
    public function __construct(
        protected IConfig $config,
    ) {
    }

    public function getConfig(): IConfig
    {
        return $this->config;
    }
}
