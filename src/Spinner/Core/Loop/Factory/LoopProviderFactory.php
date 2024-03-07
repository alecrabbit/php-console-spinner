<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Core\Loop\Factory;

use AlecRabbit\Spinner\Contract\IInvokable;
use AlecRabbit\Spinner\Contract\Mode\ExecutionMode;
use AlecRabbit\Spinner\Core\Config\Contract\IGeneralConfig;
use AlecRabbit\Spinner\Core\Factory\Contract\ILoopFactory;
use AlecRabbit\Spinner\Core\Factory\Contract\ILoopProviderFactory;
use AlecRabbit\Spinner\Core\Loop\Contract\ILoop;
use AlecRabbit\Spinner\Core\Loop\Contract\ILoopProvider;
use AlecRabbit\Spinner\Core\Loop\Contract\ILoopSetup;
use AlecRabbit\Spinner\Core\Loop\LoopProvider;
use Throwable;

final readonly class LoopProviderFactory implements ILoopProviderFactory, IInvokable
{
    private ExecutionMode $executionMode;

    public function __construct(
        private ILoopFactory $loopFactory,
        private ILoopSetup $loopSetup,
        IGeneralConfig $generalConfig,
    ) {
        $this->executionMode = $generalConfig->getExecutionMode();
    }

    public function __invoke(): ILoopProvider
    {
        return $this->create();
    }

    public function create(): ILoopProvider
    {
        return new LoopProvider(
            loop: $this->createLoop(),
        );
    }

    private function createLoop(): ?ILoop
    {
        if ($this->executionMode === ExecutionMode::SYNCHRONOUS) {
            return null;
        }
        try {
            $loop = $this->loopFactory->create();

            $this->loopSetup->setup($loop);

            return $loop;
        } catch (Throwable $_) {
            return null;
        }
    }
}
