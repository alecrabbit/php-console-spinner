<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Core\Contract;

use AlecRabbit\Spinner\Contract\IDriver;

/**
 * @deprecated
 */
interface ILegacySignalHandlersSetup
{
    public function setup(IDriver $driver): void;
}
