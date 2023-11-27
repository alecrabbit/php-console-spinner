<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Core\Factory;

use AlecRabbit\Spinner\Contract\Output\IBufferedOutput;
use AlecRabbit\Spinner\Core\Builder\Contract\ISequenceStateWriterBuilder;
use AlecRabbit\Spinner\Core\Factory\Contract\IConsoleCursorFactory;
use AlecRabbit\Spinner\Core\Factory\Contract\ISequenceStateWriterFactory;
use AlecRabbit\Spinner\Core\Feature\Resolver\Contract\IInitializationResolver;
use AlecRabbit\Spinner\Core\Output\Contract\ISequenceStateWriter;

final readonly class SequenceStateWriterFactory implements ISequenceStateWriterFactory
{
    public function __construct(
        private ISequenceStateWriterBuilder $sequenceStateWriterBuilder,
        private IBufferedOutput $bufferedOutput,
        private IConsoleCursorFactory $cursorFactory,
        private IInitializationResolver $initializationResolver,
    ) {
    }

    public function create(): ISequenceStateWriter
    {
        return $this->sequenceStateWriterBuilder
            ->withOutput(
                $this->bufferedOutput
            )
            ->withCursor(
                $this->cursorFactory->create()
            )
            ->withInitializationResolver(
                $this->initializationResolver
            )
            ->build()
        ;
    }
}
