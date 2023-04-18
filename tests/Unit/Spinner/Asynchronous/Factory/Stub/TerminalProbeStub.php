<?php

declare(strict_types=1);

namespace AlecRabbit\Tests\Unit\Spinner\Asynchronous\Factory\Stub;

use AlecRabbit\Spinner\Contract\Option\OptionStyleMode;
use AlecRabbit\Spinner\Core\Terminal\A\ATerminalProbe;

final class TerminalProbeStub extends ATerminalProbe
{
    public function isAvailable(): bool
    {
        return true;
    }

    public function getWidth(): int
    {
        // TODO: Implement getWidth() method.
    }

    public function getOptionStyleMode(): OptionStyleMode
    {
        // TODO: Implement getOptionStyleMode() method.
    }

    public function getOutputStream()
    {
        // TODO: Implement getOutputStream() method.
    }
}
