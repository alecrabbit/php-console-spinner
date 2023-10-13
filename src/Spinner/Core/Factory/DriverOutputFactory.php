<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Core\Factory;

use AlecRabbit\Spinner\Core\Builder\Contract\IDriverOutputBuilder;
use AlecRabbit\Spinner\Core\Factory\Contract\IBufferedOutputFactory;
use AlecRabbit\Spinner\Core\Factory\Contract\IConsoleCursorFactory;
use AlecRabbit\Spinner\Core\Factory\Contract\IDriverOutputFactory;
use AlecRabbit\Spinner\Core\Output\Contract\IDriverOutput;

final class DriverOutputFactory implements IDriverOutputFactory
{
    public function __construct(
        protected IDriverOutputBuilder $driverOutputBuilder,
        protected IBufferedOutputFactory $bufferedOutputFactory,
        protected IConsoleCursorFactory $cursorFactory,
    ) {
    }

    public function create(): IDriverOutput
    {
        return
            $this->driverOutputBuilder
                ->withOutput(
                    $this->bufferedOutputFactory->create()
                )
                ->withCursor(
                    $this->cursorFactory->create()
                )
                ->build()
        ;
    }
}
