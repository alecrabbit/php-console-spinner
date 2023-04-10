<?php

declare(strict_types=1);
// 03.04.23
namespace AlecRabbit\Spinner\Core\Contract;

use AlecRabbit\Spinner\Contract\Output\IBufferedOutput;
use AlecRabbit\Spinner\Core\DriverOutputBuilder;
use AlecRabbit\Spinner\Core\Output\Contract\IConsoleCursor;
use AlecRabbit\Spinner\Core\Output\Contract\IDriverOutput;

interface IDriverOutputBuilder
{
    public function build(): IDriverOutput;

    public function withOutput(IBufferedOutput $bufferedOutput): IDriverOutputBuilder;

    public function withCursor(IConsoleCursor $cursor): IDriverOutputBuilder;
}
