<?php

declare(strict_types=1);

namespace AlecRabbit\Lib\Spinner\Factory;

use AlecRabbit\Lib\Spinner\Contract\Factory\IDriverLinkerWithOutputFactory;
use AlecRabbit\Lib\Spinner\Core\DriverLinkerWithOutput;
use AlecRabbit\Spinner\Contract\Output\IOutput;
use AlecRabbit\Spinner\Core\Contract\IDriverLinker;
use AlecRabbit\Spinner\Core\DummyDriverLinker;
use AlecRabbit\Spinner\Core\Factory\Contract\IDriverLinkerFactory;

final readonly class DriverLinkerWithOutputFactory implements IDriverLinkerWithOutputFactory
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

        return new DriverLinkerWithOutput(
            $linker,
            $this->output,
        );
    }
}
