<?php

declare(strict_types=1);

namespace AlecRabbit\Lib\Spinner\Core\Factory;

use AlecRabbit\Lib\Spinner\Contract\Factory\IDecoratedLoopProviderFactory;
use AlecRabbit\Lib\Spinner\Contract\ILoopInfoPrinter;
use AlecRabbit\Spinner\Contract\IInvokable;
use AlecRabbit\Spinner\Core\Factory\Contract\ILoopProviderFactory;
use AlecRabbit\Spinner\Core\Loop\Contract\ILoopProvider;

final readonly class DecoratedLoopProviderFactory implements IDecoratedLoopProviderFactory, IInvokable
{
    public function __construct(
        private ILoopProviderFactory $loopProviderFactory,
        private ILoopInfoPrinter $loopInfoPrinter,
    ) {
    }

    public function __invoke(): ILoopProvider
    {
        return $this->create();
    }

    public function create(): ILoopProvider
    {
        $loopProvider = $this->loopProviderFactory->create();

        $loop = $loopProvider->hasLoop()
            ? $loopProvider->getLoop()
            : null;

        $this->loopInfoPrinter->print($loop);

        return $loopProvider;
    }
}
