<?php

declare(strict_types=1);
// 10.04.23
namespace AlecRabbit\Spinner\Core\Factory;

use AlecRabbit\Spinner\Core\Contract\IBufferedOutputBuilder;
use AlecRabbit\Spinner\Core\Contract\IDriverOutputBuilder;
use AlecRabbit\Spinner\Core\Factory\Contract\IBufferedOutputFactory;
use AlecRabbit\Spinner\Core\Factory\Contract\IDriverOutputFactory;
use AlecRabbit\Spinner\Core\Output\Contract\IDriverOutput;

final class DriverOutputFactory implements IDriverOutputFactory
{
    public function __construct(
        protected IDriverOutputBuilder $driverOutputBuilder,
        protected IBufferedOutputFactory $bufferedOutputFactory,
    ) {
    }

    public function create(): IDriverOutput
    {
        return
            $this->driverOutputBuilder
                ->withOutput(
                    $this->bufferedOutputFactory->create()
                )
                ->build()
        ;
    }
}
