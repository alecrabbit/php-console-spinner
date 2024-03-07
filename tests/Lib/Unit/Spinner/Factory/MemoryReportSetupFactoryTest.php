<?php

declare(strict_types=1);

namespace AlecRabbit\Tests\Lib\Unit\Spinner\Factory;

use AlecRabbit\Lib\Spinner\Contract\Factory\IMemoryReportSetupFactory;
use AlecRabbit\Lib\Spinner\Core\Loop\IMemoryReportLoopSetup;
use AlecRabbit\Lib\Spinner\Factory\MemoryReportSetupFactory;
use AlecRabbit\Spinner\Core\Loop\Contract\ILoopProvider;
use AlecRabbit\Tests\TestCase\TestCase;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\MockObject\MockObject;

final class MemoryReportSetupFactoryTest extends TestCase
{
    #[Test]
    public function canBeInstantiated(): void
    {
        $factory = $this->getTesteeInstance();

        self::assertInstanceOf(MemoryReportSetupFactory::class, $factory);
    }

    public function getTesteeInstance(
        ?IMemoryReportLoopSetup $loopSetup = null,
        ?ILoopProvider $loopProvider = null,
    ): IMemoryReportSetupFactory {
        return
            new MemoryReportSetupFactory(
                loopSetup: $loopSetup ?? $this->getMemoryReportLoopSetupMock(),
                loopProvider: $loopProvider ?? $this->getLoopProviderMock(),
            );
    }

    private function getMemoryReportLoopSetupMock(): MockObject&IMemoryReportLoopSetup
    {
        return $this->createMock(IMemoryReportLoopSetup::class);
    }

    private function getLoopProviderMock(): MockObject&ILoopProvider
    {
        return $this->createMock(ILoopProvider::class);
    }

}
