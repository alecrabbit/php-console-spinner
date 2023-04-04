<?php

declare(strict_types=1);
// 04.04.23
namespace AlecRabbit\Spinner\Core\A;

use AlecRabbit\Spinner\Contract\OptionRunMode;
use AlecRabbit\Spinner\Core\Config\Contract\ISpinnerConfig;
use AlecRabbit\Spinner\Core\Contract\ISpinner;
use AlecRabbit\Spinner\Core\Contract\ISpinnerAttacher;
use AlecRabbit\Spinner\Core\Contract\ISpinnerInitializer;
use AlecRabbit\Spinner\Exception\LogicException;

final class SpinnerInitializer implements ISpinnerInitializer
{
    protected ?ISpinnerConfig $config = null;
    protected ?OptionRunMode $runMode = null;

    public function __construct(
        protected ISpinnerAttacher $attacher,
    ) {
    }

    public function initialize(ISpinner $spinner): void
    {
        if ($this->getConfig()->isEnabledInitialization()) {
            $spinner->initialize();
        }

        if ($this->getConfig()->isEnabledAttach() || $this->isAsynchronous()) {
            $this->attacher->attach($spinner);
        }
    }

    public function useConfig(ISpinnerConfig $config): ISpinnerInitializer
    {
        $this->config = $config;
        return $this;
    }

    public function useRunMode(OptionRunMode $runMode): ISpinnerInitializer
    {
        $this->runMode = $runMode;
        return $this;
    }

    protected function isAsynchronous(): bool
    {
        if (null === $this->runMode) {
            throw new LogicException('Run mode is not set.');
        }
        return OptionRunMode::ASYNC === $this->runMode;
    }

    protected function getConfig(): ISpinnerConfig
    {
        if (null === $this->config) {
            throw new LogicException('Config is not set.');
        }
        return $this->config;
    }
}
