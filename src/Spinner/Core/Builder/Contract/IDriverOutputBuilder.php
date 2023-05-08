<?php

declare(strict_types=1);


namespace AlecRabbit\Spinner\Core\Builder\Contract;

use AlecRabbit\Spinner\Contract\Output\IBufferedOutput;
use AlecRabbit\Spinner\Core\Output\Contract\IConsoleCursor;
use AlecRabbit\Spinner\Core\Output\Contract\IDriverOutput;

interface IDriverOutputBuilder
{
    public function build(): IDriverOutput;

    public function withOutput(IBufferedOutput $bufferedOutput): IDriverOutputBuilder;

    public function withCursor(IConsoleCursor $cursor): IDriverOutputBuilder;
}
