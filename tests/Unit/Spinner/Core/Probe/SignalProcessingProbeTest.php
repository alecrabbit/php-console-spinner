<?php

declare(strict_types=1);

namespace AlecRabbit\Tests\Unit\Spinner\Core\Probe;

use AlecRabbit\Spinner\Core\Probe\SignalHandlersOptionCreator;
use AlecRabbit\Spinner\Core\Probe\SignalProcessingProbe;
use AlecRabbit\Tests\TestCase\TestCase;
use PHPUnit\Framework\Attributes\Test;

final class SignalProcessingProbeTest extends TestCase
{
    #[Test]
    public function returnsTrueOnIsSupported(): void
    {
        self::assertTrue(SignalProcessingProbe::isSupported());
    }

    #[Test]
    public function returnsCreatorClass(): void
    {
        self::assertSame(SignalHandlersOptionCreator::class, SignalProcessingProbe::getCreatorClass());
    }
}
