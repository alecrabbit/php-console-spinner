<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Core;

use AlecRabbit\Spinner\Core\Contract\IDriver;
use AlecRabbit\Spinner\Core\Contract\ISignalHandlingSetup;

/**
 * @codeCoverageIgnore
 */
final class DummySignalHandlingSetup implements ISignalHandlingSetup
{
    public function setup(IDriver $driver): void
    {
        // do nothing
    }
}
