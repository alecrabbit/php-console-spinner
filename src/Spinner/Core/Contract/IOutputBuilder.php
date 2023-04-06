<?php

declare(strict_types=1);
// 03.04.23
namespace AlecRabbit\Spinner\Core\Contract;

use AlecRabbit\Spinner\Contract\Output\IOutput;

interface IOutputBuilder
{
    public function withStream($stream): IOutputBuilder;

    public function build(): IOutput;
}
