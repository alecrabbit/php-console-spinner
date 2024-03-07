<?php

declare(strict_types=1);

namespace AlecRabbit\Lib\Spinner;

use AlecRabbit\Lib\Spinner\Contract\IDriverInfoPrinter;
use AlecRabbit\Lib\Spinner\Contract\IIntervalFormatter;
use AlecRabbit\Spinner\Contract\Output\IOutput;
use AlecRabbit\Spinner\Core\Contract\IDriver;

final readonly class DriverInfoPrinter implements IDriverInfoPrinter
{
    public function __construct(
        private IOutput $output,
        private IIntervalFormatter $formatter,
    ) {
    }

    public function print(IDriver $driver): void
    {
        $this->output->writeln(
            sprintf(
                '[%s] Update interval: %s.',
                $driver::class,
                $this->formatter->format($driver->getInterval()),
            )
        );
    }
}
