<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Core\Output\Factory;

use AlecRabbit\Spinner\Contract\Output\IResourceStream;
use AlecRabbit\Spinner\Core\Config\Contract\IOutputConfig;
use AlecRabbit\Spinner\Core\Output\Contract\Factory\IResourceStreamFactory;
use AlecRabbit\Spinner\Core\Output\ResourceStream;

final class ResourceStreamFactory implements IResourceStreamFactory
{
    public function __construct(
        protected IOutputConfig $outputConfig,
    ) {
    }

    public function create(): IResourceStream
    {
        // FIXME (2023-10-30 12:55) [Alec Rabbit]: stub!
        return new ResourceStream(STDERR);
    }
}
