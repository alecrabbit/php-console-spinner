<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Core\Factory\Contract;

use AlecRabbit\Spinner\Contract\Output\IBufferedOutput;

interface IBufferedOutputSingletonFactory
{
    public function getOutput(): IBufferedOutput;
}
