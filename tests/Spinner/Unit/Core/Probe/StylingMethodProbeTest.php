<?php

declare(strict_types=1);

namespace AlecRabbit\Tests\Spinner\Unit\Core\Probe;

use AlecRabbit\Spinner\Core\Probe\StylingMethodOptionCreator;
use AlecRabbit\Spinner\Core\Probe\StylingMethodProbe;
use AlecRabbit\Tests\TestCase\TestCase;
use PHPUnit\Framework\Attributes\Test;

final class StylingMethodProbeTest extends TestCase
{
    #[Test]
    public function returnsTrueOnIsSupported(): void
    {
        self::assertTrue(StylingMethodProbe::isSupported());
    }

    #[Test]
    public function returnsCreatorClass(): void
    {
        self::assertSame(StylingMethodOptionCreator::class, StylingMethodProbe::getCreatorClass());
    }
}
