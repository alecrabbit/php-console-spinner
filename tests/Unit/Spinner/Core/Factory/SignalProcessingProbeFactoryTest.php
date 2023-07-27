<?php

declare(strict_types=1);

namespace AlecRabbit\Tests\Unit\Spinner\Core\Factory;

use AlecRabbit\Spinner\Core\Factory\Contract\ISignalProcessingProbeFactory;
use AlecRabbit\Spinner\Core\Factory\SignalProcessingProbeFactory;
use AlecRabbit\Spinner\Core\SignalProcessingProbe;
use AlecRabbit\Tests\TestCase\TestCaseWithPrebuiltMocksAndStubs;
use PHPUnit\Framework\Attributes\Test;

final class SignalProcessingProbeFactoryTest extends TestCaseWithPrebuiltMocksAndStubs
{
    #[Test]
    public function canBeInstantiated(): void
    {
        $signalProcessingProbeFactory = $this->getTesteeInstance();

        self::assertInstanceOf(SignalProcessingProbeFactory::class, $signalProcessingProbeFactory);
    }

    public function getTesteeInstance(): ISignalProcessingProbeFactory
    {
        return new SignalProcessingProbeFactory();
    }

    #[Test]
    public function canCreateProbe(): void
    {
        $signalProcessingProbeFactory = $this->getTesteeInstance();

        self::assertInstanceOf(SignalProcessingProbeFactory::class, $signalProcessingProbeFactory);
        self::assertInstanceOf(SignalProcessingProbe::class, $signalProcessingProbeFactory->getProbe());
    }
}
