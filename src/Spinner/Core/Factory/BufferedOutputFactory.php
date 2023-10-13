<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Core\Factory;

use AlecRabbit\Spinner\Contract\Output\IBufferedOutput;
use AlecRabbit\Spinner\Contract\Output\IResourceStream;
use AlecRabbit\Spinner\Core\Builder\Contract\IBufferedOutputBuilder;
use AlecRabbit\Spinner\Core\Factory\Contract\IBufferedOutputFactory;

final class BufferedOutputFactory implements IBufferedOutputFactory
{
    /**
     * @deprecated
     */
    private static ?IBufferedOutput $bufferedOutput = null;

    public function __construct(
        protected IBufferedOutputBuilder $bufferedOutputBuilder,
        protected IResourceStream $resourceStream,
    ) {
    }

    public function create(): IBufferedOutput
    {
        if (self::$bufferedOutput === null) {
            self::$bufferedOutput = $this->bufferedOutputBuilder
                ->withStream($this->resourceStream)
                ->build()
            ;
        }

        return self::$bufferedOutput;
    }
}
