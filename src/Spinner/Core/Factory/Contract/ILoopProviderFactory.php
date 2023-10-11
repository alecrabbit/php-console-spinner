<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Core\Factory\Contract;

use AlecRabbit\Spinner\Core\Contract\Loop\ILoopProvider;

interface ILoopProviderFactory
{
    public function create(): ILoopProvider;
}
