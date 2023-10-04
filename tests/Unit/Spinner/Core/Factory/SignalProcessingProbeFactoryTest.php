<?php

declare(strict_types=1);

namespace AlecRabbit\Tests\Unit\Spinner\Core\Factory;

use AlecRabbit\Spinner\Core\Factory\Contract\ILegacySignalProcessingProbeFactory;
use AlecRabbit\Spinner\Core\Factory\LegacySignalProcessingProbeFactory;
use AlecRabbit\Spinner\Core\LegacySignalProcessingProbe;
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
