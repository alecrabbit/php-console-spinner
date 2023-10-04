<?php

declare(strict_types=1);

namespace AlecRabbit\Tests\Unit\Spinner\Core;

use AlecRabbit\Spinner\Core\Contract\ILegacySignalProcessingLegacyProbe;
use AlecRabbit\Spinner\Core\LegacySignalProcessingProbe;
use AlecRabbit\Tests\TestCase\TestCase;
use PHPUnit\Framework\Attributes\Test;

use function function_exists;

/**
 * @deprecated Will be removed
 */
/**
 * @deprecated Will be removed
 */
final class LegacySignalProcessingProbeTest extends TestCase
{
    #[Test]
    public function canBeInstantiated(): void
    {
        $driverBuilder = $this->getTesteeInstance();

        self::assertInstanceOf(LegacySignalProcessingProbe::class, $driverBuilder);
    }

    public function getTesteeInstance(): ILegacySignalProcessingLegacyProbe
    {
        return new LegacySignalProcessingProbe();
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
