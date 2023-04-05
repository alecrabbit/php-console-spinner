<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Core\Factory;

use AlecRabbit\Spinner\Core\Config\Contract\IConfig;
use AlecRabbit\Spinner\Core\Contract\ILoopSetup;
use AlecRabbit\Spinner\Core\Contract\ISpinner;
use AlecRabbit\Spinner\Core\Contract\ISpinnerBuilder;
use AlecRabbit\Spinner\Core\Contract\ISpinnerSetup;
use AlecRabbit\Spinner\Core\Factory\Contract\ISpinnerFactory;

final class SpinnerFactory implements ISpinnerFactory
{
    public function __construct(
        protected ISpinnerBuilder $spinnerBuilder,
        protected ISpinnerSetup $spinnerSetup,
        protected ILoopSetup $loopSetup,
    ) {
    }

    public function createSpinner(IConfig $config): ISpinner
    {
        return
            $this->createSpinnerAndInitializeServices($config);
    }

    protected function createSpinnerAndInitializeServices(IConfig $config): ISpinner
    {
        $spinner = $this->buildSpinner($config);

        $spinnerConfig = $config->getSpinnerConfig();
        $loopConfig = $config->getLoopConfig();

        $this->spinnerSetup
            ->enableInitialization($spinnerConfig->isEnabledInitialization())
            ->enableAttacher($spinnerConfig->isEnabledAttach() || $loopConfig->isAsynchronous())
            ->setup($spinner)
        ;

        $this->loopSetup
            ->asynchronous($loopConfig->isAsynchronous())
            ->enableAutoStart($loopConfig->isEnabledAutoStart())
            ->enableSignalHandlers($loopConfig->areEnabledSignalHandlers())
            ->setup()
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
