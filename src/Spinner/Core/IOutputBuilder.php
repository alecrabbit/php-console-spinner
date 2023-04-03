<?php

declare(strict_types=1);
// 03.04.23
namespace AlecRabbit\Spinner\Core;

use AlecRabbit\Spinner\Contract\IOutput;

interface IOutputBuilder
{
    public function withStream($stream): IOutputBuilder;

    public function build(): IOutput;
}