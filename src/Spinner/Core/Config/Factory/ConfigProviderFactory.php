<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Core\Config\Factory;

use AlecRabbit\Spinner\Core\Config\Contract\Factory\IConfigFactory;
use AlecRabbit\Spinner\Core\Config\Contract\Factory\IConfigProviderFactory;
use AlecRabbit\Spinner\Core\ConfigProvider;
use AlecRabbit\Spinner\Core\Contract\IConfigProvider;

final readonly class ConfigProviderFactory implements IConfigProviderFactory
{
    public function __construct(
        protected IConfigFactory $configFactory,
    ) {
    }

    public function create(): IConfigProvider
    {
        $config = $this->configFactory->create();

        return
            new ConfigProvider(
                config: $config,
            );
    }
}
