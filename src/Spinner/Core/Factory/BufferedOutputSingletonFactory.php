<?php

declare(strict_types=1);
// 10.04.23
namespace AlecRabbit\Spinner\Core\Factory;

use AlecRabbit\Spinner\Contract\Output\IBufferedOutput;
use AlecRabbit\Spinner\Contract\Output\IResourceStream;
use AlecRabbit\Spinner\Core\Contract\IBufferedOutputBuilder;
use AlecRabbit\Spinner\Core\Factory\Contract\IBufferedOutputSingletonFactory;

final class BufferedOutputSingletonFactory implements IBufferedOutputSingletonFactory
{
    private static ?IBufferedOutput $bufferedOutput = null;

    public function __construct(
        protected IBufferedOutputBuilder $bufferedOutputBuilder,
        protected IResourceStream $resourceStream,
    ) {
    }

    public function getOutput(): IBufferedOutput
    {
        if (null === self::$bufferedOutput) {
            self::$bufferedOutput = $this->bufferedOutputBuilder
                ->withStream($this->resourceStream)
                ->build()
            ;
        }

        return self::$bufferedOutput;
    }
}
