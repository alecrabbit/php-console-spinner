<?php

declare(strict_types=1);

namespace AlecRabbit\Lib\Spinner\Core\Factory;

use AlecRabbit\Lib\Spinner\Contract\Factory\IDecoratedLoopProviderFactory;
use AlecRabbit\Lib\Spinner\Contract\ILoopInfoFormatter;
use AlecRabbit\Spinner\Contract\IInvokable;
use AlecRabbit\Spinner\Contract\Output\IOutput;
use AlecRabbit\Spinner\Core\Factory\Contract\ILoopProviderFactory;
use AlecRabbit\Spinner\Core\Loop\Contract\ILoopProvider;

final readonly class DecoratedLoopProviderFactory implements IDecoratedLoopProviderFactory, IInvokable
{
    public function __construct(
        private ILoopProviderFactory $loopProviderFactory,
        private IOutput $output,
        private ILoopInfoFormatter $loopInfoFormatter,
    ) {
    }

    public function __invoke(): ILoopProvider
    {
        return $this->create();
    }

    public function create(): ILoopProvider
    {
        $loopProvider = $this->loopProviderFactory->create();

        $this->info($loopProvider);

        return $loopProvider;
    }

    private function info(ILoopProvider $loopProvider): void
    {
        $loop = null;

        if ($loopProvider->hasLoop()) {
            $loop = $loopProvider->getLoop();
        }

        $this->output->writeln(
            $this->loopInfoFormatter->format($loop)
        );
    }
}
