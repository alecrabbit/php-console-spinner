<?php

declare(strict_types=1);

namespace AlecRabbit\Tests\Lib\Unit\Spinner\Core\Factory;

use AlecRabbit\Lib\Spinner\Contract\Factory\IMemoryReportLoopSetupFactory;
use AlecRabbit\Lib\Spinner\Core\Factory\DecoratedLoopSetupFactory;
use AlecRabbit\Lib\Spinner\Core\Loop\IMemoryReportLoopSetup;
use AlecRabbit\Spinner\Core\Factory\Contract\ILoopSetupFactory;
use AlecRabbit\Tests\TestCase\TestCase;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\MockObject\MockObject;

final class DecoratedLoopSetupFactoryTest extends TestCase
{
    #[Test]
    public function canBeInstantiated(): void
    {
        $loopSetupFactory = $this->getTesteeInstance();

        self::assertInstanceOf(DecoratedLoopSetupFactory::class, $loopSetupFactory);
    }

    private function getTesteeInstance(
        ?ILoopSetupFactory $loopSetupFactory = null,
        ?IMemoryReportLoopSetupFactory $memoryReportLoopSetup = null,
    ): ILoopSetupFactory {
        return new DecoratedLoopSetupFactory(
            loopSetupFactory: $loopSetupFactory ?? $this->getLoopSetupFactoryMock(),
            memoryReportLoopSetupFactory: $memoryReportLoopSetup ?? $this->getMemoryReportLoopSetupFactoryMock(),
        );
    }

    private function getLoopSetupFactoryMock(): MockObject&ILoopSetupFactory
    {
        return $this->createMock(ILoopSetupFactory::class);
    }

    private function getMemoryReportLoopSetupMock(): MockObject&IMemoryReportLoopSetup
    {
        return $this->createMock(IMemoryReportLoopSetup::class);
    }

    private function getMemoryReportLoopSetupFactoryMock(): MockObject&IMemoryReportLoopSetupFactory
    {
        return $this->createMock(IMemoryReportLoopSetupFactory::class);
    }
}
