<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Core\Factory;

use AlecRabbit\Spinner\Core\Contract\Loop\ILoop;
use AlecRabbit\Spinner\Core\Contract\Loop\ILoopProvider;
use AlecRabbit\Spinner\Core\Factory\Contract\ILoopFactory;
use AlecRabbit\Spinner\Core\Factory\Contract\ILoopProviderFactory;
use AlecRabbit\Spinner\Core\LoopProvider;
use Throwable;

final readonly class LoopProviderFactory implements ILoopProviderFactory
{
    public function __construct(
        protected ILoopFactory $loopFactory,
    ) {
    }

    public function create(): ILoopProvider
    {
        $loop = $this->createLoop();

        if ($loop instanceof ILoop) {
            $this->setup($loop);
        }

        return
            new LoopProvider(
                loop: $loop,
            );
    }

    private function createLoop(): ?ILoop
    {
        try {
            return $this->loopFactory->create();
        } catch (Throwable $_) {
            return null;
        }
    }

    private function setup(ILoop $loop): void
    {
        // FIXME (2023-10-09 15:29) [Alec Rabbit]: Setup loop
    }
}
