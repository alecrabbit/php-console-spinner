<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Core\Builder\Contract;

use AlecRabbit\Spinner\Contract\Output\IBufferedOutput;
use AlecRabbit\Spinner\Contract\Output\IResourceStream;

interface IBufferedOutputBuilder
{
    public function withStream(IResourceStream $stream): IBufferedOutputBuilder;

    public function build(): IBufferedOutput;
}
