<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Core\Output\Factory;

use AlecRabbit\Spinner\Contract\Output\IWritableStream;
use AlecRabbit\Spinner\Core\Config\Contract\IOutputConfig;
use AlecRabbit\Spinner\Core\Output\Contract\Factory\IResourceStreamFactory;
use AlecRabbit\Spinner\Core\Output\WritableStream;

final class ResourceStreamFactory implements IResourceStreamFactory
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
