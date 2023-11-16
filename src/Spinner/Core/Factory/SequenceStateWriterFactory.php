<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Core\Factory;

use AlecRabbit\Spinner\Contract\Output\IBufferedOutput;
use AlecRabbit\Spinner\Core\Builder\Contract\ISequenceStateWriterBuilder;
use AlecRabbit\Spinner\Core\Factory\Contract\IBufferedOutputFactory;
use AlecRabbit\Spinner\Core\Factory\Contract\IConsoleCursorFactory;
use AlecRabbit\Spinner\Core\Factory\Contract\ISequenceStateWriterFactory;
use AlecRabbit\Spinner\Core\Output\Contract\ISequenceStateWriter;

final class SequenceStateWriterFactory implements ISequenceStateWriterFactory
{
    public function __construct(
        protected ISequenceStateWriterBuilder $sequenceStateWriterBuilder,
        protected IBufferedOutput $bufferedOutput,
        protected IConsoleCursorFactory $cursorFactory,
    ) {
    }

    public function create(): ISequenceStateWriter
    {
        return
            $this->sequenceStateWriterBuilder
                ->withOutput(
                    $this->bufferedOutput
                )
                ->withCursor(
                    $this->cursorFactory->create()
                )
                ->build()
        ;
    }
}
