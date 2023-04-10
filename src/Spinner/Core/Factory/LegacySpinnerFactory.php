<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Core\Factory;

use AlecRabbit\Spinner\Core\Config\Contract\IConfig;
use AlecRabbit\Spinner\Core\Contract\ILegacySpinner;
use AlecRabbit\Spinner\Core\Contract\ILegacySpinnerBuilder;
use AlecRabbit\Spinner\Core\Contract\ILegacySpinnerSetup;
use AlecRabbit\Spinner\Core\Factory\Contract\ILegacySpinnerFactory;

final class LegacySpinnerFactory implements ILegacySpinnerFactory
{
    public function __construct(
        protected ILegacySpinnerBuilder $spinnerBuilder,
        protected ILegacySpinnerSetup $spinnerSetup,
    ) {
    }

    public function createSpinner(IConfig $config): ILegacySpinner
    {
        return
            $this->createAndSetupSpinner($config);
    }

    protected function createAndSetupSpinner(IConfig $config): ILegacySpinner
    {
        $spinner = $this->buildSpinner($config);

        $spinnerConfig = $config->getSpinnerConfig();

        $this->spinnerSetup
            ->enableInitialization($spinnerConfig->isEnabledInitialization())
            ->enableAttacher($spinnerConfig->isEnabledAttach())
            ->setup($spinner)
        ;

        return $spinner;
    }

    protected function buildSpinner(IConfig $config): ILegacySpinner
    {
        return
            $this->spinnerBuilder
                ->withConfig($config)
                ->build()
        ;
    }
}
