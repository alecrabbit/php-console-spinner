<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Core\Factory\Contract;

use AlecRabbit\Spinner\Contract\Output\IBufferedOutput;

interface IBufferedOutputFactory
{
    public function create(): IBufferedOutput;
}