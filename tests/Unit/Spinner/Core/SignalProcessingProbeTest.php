<?php

declare(strict_types=1);

namespace AlecRabbit\Tests\Unit\Spinner\Core;

use AlecRabbit\Spinner\Core\Contract\ISignalProcessingProbe;
use AlecRabbit\Spinner\Core\SignalProcessingProbe;
use AlecRabbit\Tests\TestCase\TestCase;
use PHPUnit\Framework\Attributes\Test;

use function function_exists;

final class SignalProcessingProbeTest extends TestCase
{
    #[Test]
    public function canBeInstantiated(): void
    {
        $driverBuilder = $this->getTesteeInstance();

        self::assertInstanceOf(SignalProcessingProbe::class, $driverBuilder);
    }

    public function getTesteeInstance(): ISignalProcessingProbe
    {
        return new SignalProcessingProbe();
    }

    #[Test]
    public function canDetectAvailabilityOfSignalProcessing(): void
    {
        $signalProcessingProbe = $this->getTesteeInstance();
        if (function_exists('pcntl_signal_dispatch')) {
            self::assertTrue($signalProcessingProbe->isAvailable());
        } else {
            self::assertFalse($signalProcessingProbe->isAvailable());
        }
    }
}
