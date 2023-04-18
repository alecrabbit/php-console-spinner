<?php

declare(strict_types=1);

namespace AlecRabbit\Tests\Unit\Spinner\Core\Terminal;

use AlecRabbit\Spinner\Contract\Output\IBufferedOutput;
use AlecRabbit\Spinner\Contract\Output\IOutput;
use AlecRabbit\Spinner\Core\BufferedOutputBuilder;
use AlecRabbit\Spinner\Core\Contract\IBufferedOutputBuilder;
use AlecRabbit\Spinner\Core\Terminal\Contract\ITerminalProbe;
use AlecRabbit\Spinner\Core\Terminal\NativeTerminalProbe;
use AlecRabbit\Spinner\Exception\LogicException;
use AlecRabbit\Tests\TestCase\TestCaseWithPrebuiltMocksAndStubs;
use PHPUnit\Framework\Attributes\Test;

final class NativeTerminalProbeTest extends TestCaseWithPrebuiltMocksAndStubs
{
    #[Test]
    public function canBeCreated(): void
    {
        $probe = $this->getTesteeInstance();

        self::assertInstanceOf(NativeTerminalProbe::class, $probe);
    }

    public function getTesteeInstance(): ITerminalProbe
    {
        return new NativeTerminalProbe();
    }

    #[Test]
    public function returnsDefaultValues(): void
    {
        $probe = $this->getTesteeInstance();

        self::assertTrue($probe->isAvailable());
        self::assertSame(ITerminalProbe::DEFAULT_TERMINAL_WIDTH, $probe->getWidth());
        self::assertSame(ITerminalProbe::DEFAULT_OPTION_STYLE_MODE, $probe->getOptionStyleMode());
        self::assertSame(ITerminalProbe::DEFAULT_OPTION_CURSOR, $probe->getOptionCursor());
        self::assertSame(STDERR, $probe->getOutputStream());
    }
}
