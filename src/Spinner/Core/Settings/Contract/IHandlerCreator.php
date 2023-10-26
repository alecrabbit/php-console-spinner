<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Core\Settings\Contract;

use AlecRabbit\Spinner\Core\Contract\IDriver;
use AlecRabbit\Spinner\Core\Loop\Contract\ILoop;

interface IHandlerCreator
{
    public function createHandler(IDriver $driver, ILoop $loop): \Closure;
}
