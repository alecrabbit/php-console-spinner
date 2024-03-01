<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Core\Settings\Factory;

use AlecRabbit\Spinner\Contract\IInvokable;
use AlecRabbit\Spinner\Core\Settings\Contract\Builder\ISettingsProviderBuilder;
use AlecRabbit\Spinner\Core\Settings\Contract\Factory\IDefaultSettingsFactory;
use AlecRabbit\Spinner\Core\Settings\Contract\Factory\IDetectedSettingsFactory;
use AlecRabbit\Spinner\Core\Settings\Contract\Factory\ISettingsProviderFactory;
use AlecRabbit\Spinner\Core\Settings\Contract\Factory\IUserSettingsFactory;
use AlecRabbit\Spinner\Core\Settings\Contract\ISettingsProvider;

final readonly class SettingsProviderFactory implements ISettingsProviderFactory,
                                                        IInvokable
{
    public function __construct(
        protected ISettingsProviderBuilder $builder,
        protected IUserSettingsFactory $userSettingsFactory,
        protected IDetectedSettingsFactory $detectedSettingsFactory,
        protected IDefaultSettingsFactory $defaultSettingsFactory,
    ) {
    }

    public function __invoke(): ISettingsProvider
    {
        return $this->create();
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
