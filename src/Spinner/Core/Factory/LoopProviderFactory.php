<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Core\Factory;

use AlecRabbit\Spinner\Core\Contract\Loop\ILoop;
use AlecRabbit\Spinner\Core\Contract\Loop\ILoopProvider;
use AlecRabbit\Spinner\Core\Contract\Loop\ILoopSetup;
use AlecRabbit\Spinner\Core\Factory\Contract\ILoopFactory;
use AlecRabbit\Spinner\Core\Factory\Contract\ILoopProviderFactory;
use AlecRabbit\Spinner\Core\LoopProvider;
use Throwable;

final readonly class LoopProviderFactory implements ILoopProviderFactory
{
    public function __construct(
        protected ILoopFactory $loopFactory,
        protected ILoopSetup $loopSetup,
    ) {
    }

    public function create(): ILoopProvider
    {
        return
            new LoopProvider(
                loop: $this->createLoop(),
            );
    }

    private function createLoop(): ?ILoop
    {
        try {
            $loop = $this->loopFactory->create();

            $this->loopSetup->setup($loop);

            return $loop;
        } catch (Throwable $_) {
            return null;
        }
    }

}
