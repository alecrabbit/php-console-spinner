<?php

declare(strict_types=1);
// 03.04.23
namespace AlecRabbit\Spinner\Core\Contract;

use AlecRabbit\Spinner\Contract\Output\IBufferedOutput;
use AlecRabbit\Spinner\Contract\Output\IResourceStream;

interface IBufferedOutputBuilder
{
    public function withStreamHandler($stream): IBufferedOutputBuilder;

    public function withStream(IResourceStream $stream): IBufferedOutputBuilder;

    public function build(): IBufferedOutput;
}
