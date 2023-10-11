<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Core\Contract;

/**
 * @deprecated
 */
interface ILegacySignalHandlersSetup
{
    public function setup(IDriver $driver): void;
}
