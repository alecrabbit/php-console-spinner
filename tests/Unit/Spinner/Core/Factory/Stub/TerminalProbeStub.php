<?php

declare(strict_types=1);

namespace AlecRabbit\Tests\Unit\Spinner\Core\Factory\Stub;

use AlecRabbit\Spinner\Contract\Option\StylingMethodOption;
use AlecRabbit\Spinner\Core\Terminal\A\ATerminalProbe;
use RuntimeException;

final class TerminalProbeStub extends ATerminalProbe
{
    public function isAvailable(): bool
    {
        return true;
    }

    public function getWidth(): int
    {
        throw new RuntimeException('Not implemented.'); // Unimplemented intentionally
    }

    public function getOptionStyleMode(): StylingMethodOption
    {
        throw new RuntimeException('Not implemented.'); // Unimplemented intentionally
    }

    public function getOutputStream()
    {
        throw new RuntimeException('Not implemented.'); // Unimplemented intentionally
    }
}
