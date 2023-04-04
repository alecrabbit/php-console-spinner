<?php

declare(strict_types=1);
// 04.04.23
namespace AlecRabbit\Spinner\Core\Contract;

use AlecRabbit\Spinner\Core\Config\Contract\ILoopConfig;
use AlecRabbit\Spinner\Core\Factory\Contract\ILoopFactory;
use AlecRabbit\Spinner\Exception\LogicException;

final class LoopInitializer implements ILoopInitializer
{
    protected ?ILoopConfig $config = null;

    public function __construct(
        protected ILoopFactory $loopFactory,
    ) {
    }

    public function initialize(): void
    {
        if ($this->getConfig()->isAsynchronous()) {
            if ($this->getConfig()->isEnabledAutoStart()) {
                $this->loopFactory->registerAutoStart();
            }
            if ($this->getConfig()->areEnabledSignalHandlers()) {
                $this->loopFactory->registerSignalHandlers();
            }
        }
    }

    private function getConfig(): ILoopConfig
    {
        if (null === $this->config) {
            throw new LogicException('Config is not set.');
        }
        return $this->config;
    }

    public function useConfig(ILoopConfig $config): ILoopInitializer
    {
        $this->config = $config;
        return $this;
    }
}
