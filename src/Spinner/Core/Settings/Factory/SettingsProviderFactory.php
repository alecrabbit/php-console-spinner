<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Core\Settings\Factory;

use AlecRabbit\Spinner\Core\Settings\Contract\Builder\ISettingsProviderBuilder;
use AlecRabbit\Spinner\Core\Settings\Contract\Factory\IDefaultSettingsFactory;
use AlecRabbit\Spinner\Core\Settings\Contract\Factory\IDetectedSettingsFactory;
use AlecRabbit\Spinner\Core\Settings\Contract\Factory\ISettingsProviderFactory;
use AlecRabbit\Spinner\Core\Settings\Contract\Factory\IUserSettingsFactory;
use AlecRabbit\Spinner\Core\Settings\Contract\ISettingsProvider;

final readonly class SettingsProviderFactory implements ISettingsProviderFactory
{
    public function __construct(
        protected ISettingsProviderBuilder $builder,
        protected IUserSettingsFactory $userSettingsFactory,
        protected IDetectedSettingsFactory $detectedSettingsFactory,
        protected IDefaultSettingsFactory $defaultSettingsFactory,
    ) {
    }

    public function create(): ISettingsProvider
    {
        return $this->builder
            ->withSettings($this->userSettingsFactory->create())
            ->withDefaultSettings($this->defaultSettingsFactory->create())
            ->withDetectedSettings($this->detectedSettingsFactory->create())
            ->build()
        ;
    }
}
