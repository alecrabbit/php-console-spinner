<?php

declare(strict_types=1);

namespace AlecRabbit\Tests\Unit\Spinner\Core\Terminal;

use AlecRabbit\Spinner\Core\Legacy\Terminal\Contract\ITerminalLegacyProbe;
use AlecRabbit\Spinner\Core\Legacy\Terminal\NativeTerminalLegacyProbe;
use AlecRabbit\Tests\TestCase\TestCaseWithPrebuiltMocksAndStubs;
use PHPUnit\Framework\Attributes\Test;

final class NativeTerminalProbeTest extends TestCaseWithPrebuiltMocksAndStubs
{
    #[Test]
    public function canBeInstantiated(): void
    {
        $probe = $this->getTesteeInstance();

        self::assertInstanceOf(NativeTerminalLegacyProbe::class, $probe);
    }

    public function getTesteeInstance(): ITerminalLegacyProbe
    {
        return new NativeTerminalLegacyProbe();
    }

    #[Test]
    public function returnsDefaultValues(): void
    {
        $probe = $this->getTesteeInstance();

        self::assertTrue($probe->isAvailable());
        self::assertSame(ITerminalLegacyProbe::DEFAULT_TERMINAL_WIDTH, $probe->getWidth());
        self::assertSame(ITerminalLegacyProbe::DEFAULT_OPTION_STYLE_MODE, $probe->getOptionStyleMode());
        self::assertSame(ITerminalLegacyProbe::DEFAULT_OPTION_CURSOR, $probe->getOptionCursor());
        self::assertSame(STDERR, $probe->getOutputStream());
    }
}
