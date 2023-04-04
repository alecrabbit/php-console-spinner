<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Core\Factory;

use AlecRabbit\Spinner\Core\Config\Contract\IConfig;
use AlecRabbit\Spinner\Core\Contract\IConfigBuilder;
use AlecRabbit\Spinner\Core\Contract\ILoopInitializer;
use AlecRabbit\Spinner\Core\Contract\ISpinner;
use AlecRabbit\Spinner\Core\Contract\ISpinnerBuilder;
use AlecRabbit\Spinner\Core\Contract\ISpinnerInitializer;
use AlecRabbit\Spinner\Core\Factory\Contract\ISpinnerFactory;

final class SpinnerFactory implements ISpinnerFactory
{
    public function __construct(
        protected ISpinnerBuilder $spinnerBuilder,
        protected ISpinnerInitializer $spinnerInitializer,
        protected ILoopInitializer $loopInitializer,
        protected IConfigBuilder $configBuilder,
    ) {
    }

    public function createSpinner(IConfig $config = null): ISpinner
    {
        return
            $this->createSpinnerAndInitializeServices(
                $this->refineConfig($config)
            );
    }

    protected function refineConfig(?IConfig $config): IConfig
    {
        return
            $config ?? $this->configBuilder->build();
    }

    protected function createSpinnerAndInitializeServices(IConfig $config): ISpinner
    {
        $spinner = $this->buildSpinner($config);

        $this->spinnerInitializer
            ->useConfig($config->getSpinnerConfig())
            ->useRunMode($config->getLoopConfig()->getRunMode())
            ->initialize($spinner)
        ;

        $this->loopInitializer
            ->useConfig($config->getLoopConfig())
            ->initialize()
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
