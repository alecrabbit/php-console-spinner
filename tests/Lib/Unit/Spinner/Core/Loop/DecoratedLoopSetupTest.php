<?php

declare(strict_types=1);

namespace AlecRabbit\Tests\Lib\Unit\Spinner\Core\Loop;

use AlecRabbit\Lib\Spinner\Contract\IMemoryReportPrinter;
use AlecRabbit\Lib\Spinner\Core\Loop\DecoratedLoopSetup;
use AlecRabbit\Spinner\Core\Loop\Contract\ILoopSetup;
use AlecRabbit\Tests\TestCase\TestCase;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\MockObject\MockObject;

final class DecoratedLoopSetupTest extends TestCase
{
    #[Test]
    public function canBeInstantiated(): void
    {
        $provider = $this->getTesteeInstance();

        self::assertInstanceOf(DecoratedLoopSetup::class, $provider);
    }

    private function getTesteeInstance(
        ?IMemoryReportPrinter $memoryReportPrinter = null,
    ): ILoopSetup {
        return new DecoratedLoopSetup(
            memoryReportPrinter: $memoryReportPrinter ?? $this->getMemoryReportPrinterMock(),
        );
    }

    private function getLoopSetupMock(): MockObject&ILoopSetup
    {
        return $this->createMock(ILoopSetup::class);
    }

    private function getMemoryReportPrinterMock(): MockObject&IMemoryReportPrinter
    {
        return $this->createMock(IMemoryReportPrinter::class);
    }
}
