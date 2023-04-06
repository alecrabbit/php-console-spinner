<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Core\Factory;

use AlecRabbit\Spinner\Core\Config\Contract\IConfig;
use AlecRabbit\Spinner\Core\Contract\ISpinner;
use AlecRabbit\Spinner\Core\Contract\ISpinnerBuilder;
use AlecRabbit\Spinner\Core\Contract\ISpinnerSetup;
use AlecRabbit\Spinner\Core\Factory\Contract\ISpinnerFactory;

final class SpinnerFactory implements ISpinnerFactory
{
    public function __construct(
        protected ISpinnerBuilder $spinnerBuilder,
        protected ISpinnerSetup $spinnerSetup,
    ) {
    }

    public function createSpinner(IConfig $config): ISpinner
    {
        return
            $this->createAndSetupSpinner($config);
    }

    protected function createAndSetupSpinner(IConfig $config): ISpinner
    {
        $spinner = $this->buildSpinner($config);

        $spinnerConfig = $config->getSpinnerConfig();
        $loopConfig = $config->getLoopConfig();

        $this->spinnerSetup
            ->enableInitialization($spinnerConfig->isEnabledInitialization())
            ->enableAttacher($spinnerConfig->isEnabledAttach() || $loopConfig->isRunModeAsynchronous())
            ->setup($spinner)
        ;

        return $spinner;
    }

    protected function buildSpinner(IConfig $config): ISpinner
    {
        return
            $this->spinnerBuilder
                ->withConfig($config)
                ->build()
        ;
    }
}
