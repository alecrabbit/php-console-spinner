<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Core\Output\Factory;

use AlecRabbit\Spinner\Contract\Output\IWritableStream;
use AlecRabbit\Spinner\Core\Config\Contract\IOutputConfig;
use AlecRabbit\Spinner\Core\Output\Contract\Factory\IWritableStreamFactory;
use AlecRabbit\Spinner\Core\Output\WritableStream;

final class WritableStreamFactory implements IWritableStreamFactory
{
    public function __construct(
        protected IOutputConfig $outputConfig,
    ) {
    }

    public function create(): IWritableStream
    {
        return new WritableStream(
            $this->outputConfig->getStream()
        );
    }
}
