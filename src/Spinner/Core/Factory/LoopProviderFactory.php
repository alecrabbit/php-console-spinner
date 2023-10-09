<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Core\Factory;

use AlecRabbit\Spinner\Core\Contract\Loop\ILoopProvider;
use AlecRabbit\Spinner\Core\Factory\Contract\ILoopFactory;
use AlecRabbit\Spinner\Core\Factory\Contract\ILoopProviderFactory;
use AlecRabbit\Spinner\Core\LoopProvider;

final readonly class LoopProviderFactory implements ILoopProviderFactory
{
    public function __construct(
        protected ILoopFactory $loopFactory,
    ) {
    }

    public function create(): ILoopProvider
    {
        $loop = $this->loopFactory->create();

        return
            new LoopProvider(
                loop: $loop,
            );
    }
}
