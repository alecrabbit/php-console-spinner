<?php

declare(strict_types=1);

namespace AlecRabbit\Tests\Spinner\Unit\Core\Probe;

use AlecRabbit\Spinner\Core\Probe\SignalHandlingOptionCreator;
use AlecRabbit\Spinner\Core\Probe\SignalHandlingProbe;
use AlecRabbit\Tests\TestCase\TestCase;
use PHPUnit\Framework\Attributes\Test;

final class SignalHandlingProbeTest extends TestCase
{
    #[Test]
    public function returnsTrueOnIsSupported(): void
    {
        self::assertTrue(SignalHandlingProbe::isSupported());
    }

    #[Test]
    public function returnsCreatorClass(): void
    {
        self::assertSame(SignalHandlingOptionCreator::class, SignalHandlingProbe::getCreatorClass());
    }
}
