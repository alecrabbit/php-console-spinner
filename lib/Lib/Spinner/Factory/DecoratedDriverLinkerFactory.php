<?php

declare(strict_types=1);

namespace AlecRabbit\Lib\Spinner\Factory;

use AlecRabbit\Lib\Spinner\Contract\Factory\IDecoratedDriverLinkerFactory;
use AlecRabbit\Lib\Spinner\Contract\IIntervalFormatter;
use AlecRabbit\Lib\Spinner\Core\DecoratedDriverLinker;
use AlecRabbit\Spinner\Contract\IInvokable;
use AlecRabbit\Spinner\Contract\Output\IOutput;
use AlecRabbit\Spinner\Core\Contract\IDriverLinker;
use AlecRabbit\Spinner\Core\Driver\DummyDriverLinker;
use AlecRabbit\Spinner\Core\Factory\Contract\IDriverLinkerFactory;

final readonly class DecoratedDriverLinkerFactory implements IDecoratedDriverLinkerFactory, IInvokable
{
    public function __construct(
        private IDriverLinkerFactory $driverLinkerFactory,
        private IOutput $output,
        private IIntervalFormatter $intervalFormatter,
    ) {
    }

    public function create(): IDriverLinker
    {
        $linker = $this->driverLinkerFactory->create();

        if ($linker instanceof DummyDriverLinker) {
            return $linker;
        }

        return new DecoratedDriverLinker(
            $linker,
            $this->output,
            $this->intervalFormatter,
        );
    }

    public function __invoke(): IDriverLinker
    {
        return $this->create();
    }
}
