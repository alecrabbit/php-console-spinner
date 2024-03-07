<?php

declare(strict_types=1);

namespace AlecRabbit\Tests\Lib\Unit\Spinner\Core\Factory;

use AlecRabbit\Lib\Spinner\Contract\ILoopInfoFormatter;
use AlecRabbit\Lib\Spinner\Contract\IMemoryReportPrinter;
use AlecRabbit\Lib\Spinner\Core\Factory\DecoratedLoopSetupFactory;
use AlecRabbit\Spinner\Contract\Output\IOutput;
use AlecRabbit\Spinner\Core\Factory\Contract\ILoopSetupFactory;
use AlecRabbit\Spinner\Core\Loop\Contract\ILoop;
use AlecRabbit\Spinner\Core\Loop\Contract\ILoopSetup;
use AlecRabbit\Tests\TestCase\TestCase;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\MockObject\MockObject;

final class DecoratedLoopSetupFactoryTest extends TestCase
{
    #[Test]
    public function canBeInstantiated(): void
    {
        $provider = $this->getTesteeInstance();

        self::assertInstanceOf(DecoratedLoopSetupFactory::class, $provider);
    }

    private function getTesteeInstance(
        ?ILoopSetupFactory $loopSetupFactory = null,
        ?IMemoryReportPrinter $memoryReportPrinter = null,
    ): ILoopSetupFactory {
        return new DecoratedLoopSetupFactory(
            loopSetupFactory: $loopSetupFactory ?? $this->getLoopSetupFactoryMock(),
            memoryReportPrinter: $memoryReportPrinter ?? $this->getMemoryReportPrinterMock(),
        );
    }

    private function getLoopSetupFactoryMock(): MockObject&ILoopSetupFactory
    {
        return $this->createMock(ILoopSetupFactory::class);
    }

    private function getMemoryReportPrinterMock(): MockObject&IMemoryReportPrinter
    {
        return $this->createMock(IMemoryReportPrinter::class);
    }

}
