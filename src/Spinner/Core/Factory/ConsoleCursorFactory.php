<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Core\Factory;

use AlecRabbit\Spinner\Core\Builder\Contract\IConsoleCursorBuilder;
use AlecRabbit\Spinner\Core\Config\Contract\IOutputConfig;
use AlecRabbit\Spinner\Core\Factory\Contract\IBufferedOutputSingletonFactory;
use AlecRabbit\Spinner\Core\Factory\Contract\IConsoleCursorFactory;
use AlecRabbit\Spinner\Core\Output\Contract\IConsoleCursor;

final class ConsoleCursorFactory implements IConsoleCursorFactory
{
    public function __construct(
        protected IBufferedOutputSingletonFactory $bufferedOutputFactory,
        protected IConsoleCursorBuilder $cursorBuilder,
        protected IOutputConfig $outputConfig,
    ) {
    }

    public function create(): IConsoleCursor
    {
        return $this->cursorBuilder
            ->withOutput(
                $this->bufferedOutputFactory->getOutput()
            )
            ->withCursorVisibilityMode(
                $this->outputConfig->getCursorVisibilityMode()
            )
            ->build()
        ;
    }
}
