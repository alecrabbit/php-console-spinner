<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Core\Factory\Config;

use AlecRabbit\Spinner\Core\ConfigProvider;
use AlecRabbit\Spinner\Core\Contract\IConfigProvider;
use AlecRabbit\Spinner\Core\Factory\Config\Contract\IConfigProviderFactory;
use AlecRabbit\Tests\Unit\Spinner\Core\Factory\Config\IConfigFactory;

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
