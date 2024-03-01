<?php

declare(strict_types=1);

namespace AlecRabbit\Lib\Spinner\Factory;

use AlecRabbit\Lib\Spinner\Contract\Factory\IDriverLinkerDecoratorFactory;
use AlecRabbit\Lib\Spinner\Core\DriverLinkerDecorator;
use AlecRabbit\Spinner\Contract\IInvokable;
use AlecRabbit\Spinner\Contract\Output\IOutput;
use AlecRabbit\Spinner\Core\Contract\IDriverLinker;
use AlecRabbit\Spinner\Core\Driver\DummyDriverLinker;
use AlecRabbit\Spinner\Core\Factory\Contract\IDriverLinkerFactory;

final readonly class DriverLinkerDecoratorFactory implements IDriverLinkerDecoratorFactory, IInvokable
{
    public function __construct(
        private IDriverLinkerFactory $driverLinkerFactory,
        private IOutput $output,
    ) {
    }

    public function create(): IDriverLinker
    {
        $linker = $this->driverLinkerFactory->create();

        if ($linker instanceof DummyDriverLinker) {
            return $linker;
        }

        return new DriverLinkerDecorator(
            $linker,
            $this->output,
        );
    }

    public function __invoke(): IDriverLinker
    {
        return $this->create();
    }
}
