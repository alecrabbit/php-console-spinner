<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Core;

use AlecRabbit\Spinner\Contract\ISubject;
use AlecRabbit\Spinner\Core\Contract\IDriver;
use AlecRabbit\Spinner\Core\Contract\IDriverLinker;

/**
 * @codeCoverageIgnore
 */
final class DummyDriverLinker implements IDriverLinker
{
    public function link(IDriver $driver): void
    {
        // do nothing
    }

    public function update(ISubject $subject): void
    {
        // do nothing
    }
}
