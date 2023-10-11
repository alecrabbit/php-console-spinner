<?php

declare(strict_types=1);

namespace AlecRabbit\Tests\Unit\Spinner\Core\Factory;

use AlecRabbit\Spinner\Core\Legacy\ILegacySignalProcessingProbeFactory;
use AlecRabbit\Spinner\Core\Legacy\LegacySignalProcessingProbe;
use AlecRabbit\Spinner\Core\Legacy\LegacySignalProcessingProbeFactory;
use AlecRabbit\Tests\TestCase\TestCaseWithPrebuiltMocksAndStubs;
use PHPUnit\Framework\Attributes\Test;

final class SignalProcessingProbeFactoryTest extends TestCaseWithPrebuiltMocksAndStubs
{
    #[Test]
    public function canBeInstantiated(): void
    {
        $signalProcessingProbeFactory = $this->getTesteeInstance();

        self::assertInstanceOf(LegacySignalProcessingProbeFactory::class, $signalProcessingProbeFactory);
    }

    public function getTesteeInstance(): ILegacySignalProcessingProbeFactory
    {
        return new LegacySignalProcessingProbeFactory();
    }

    #[Test]
    public function canCreateProbe(): void
    {
        $signalProcessingProbeFactory = $this->getTesteeInstance();

        self::assertInstanceOf(LegacySignalProcessingProbeFactory::class, $signalProcessingProbeFactory);
        self::assertInstanceOf(LegacySignalProcessingProbe::class, $signalProcessingProbeFactory->getProbe());
    }
}
