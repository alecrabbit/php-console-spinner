<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Core\Builder\Contract;

use AlecRabbit\Spinner\Contract\Output\IBufferedOutput;
use AlecRabbit\Spinner\Core\Feature\Resolver\Contract\IInitializationResolver;
use AlecRabbit\Spinner\Core\Output\Contract\IConsoleCursor;
use AlecRabbit\Spinner\Core\Output\Contract\ISequenceStateWriter;

interface ISequenceStateWriterBuilder
{
    public function build(): ISequenceStateWriter;

    public function withOutput(IBufferedOutput $bufferedOutput): ISequenceStateWriterBuilder;

    public function withCursor(IConsoleCursor $cursor): ISequenceStateWriterBuilder;

    public function withInitializationResolver(
        IInitializationResolver $initializationResolver
    ): ISequenceStateWriterBuilder;
}
