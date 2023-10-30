<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Core\Factory;

use AlecRabbit\Spinner\Contract\Output\IBufferedOutput;
use AlecRabbit\Spinner\Contract\Output\IResourceStream;
use AlecRabbit\Spinner\Core\Factory\Contract\IBufferedOutputFactory;
use AlecRabbit\Spinner\Core\Output\StreamBufferedOutput;

final class BufferedOutputFactory implements IBufferedOutputFactory
{
    public function __construct(
        protected IResourceStream $resourceStream,
    ) {
    }

    public function create(): IBufferedOutput
    {
        return
            new StreamBufferedOutput($this->resourceStream);
    }
}
