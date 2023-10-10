<?php

declare(strict_types=1);

namespace AlecRabbit\Tests\Unit\Spinner\Core\Probe;

use AlecRabbit\Spinner\Core\Probe\ColorSupportProbe;
use AlecRabbit\Spinner\Core\Probe\StylingMethodOptionCreator;
use AlecRabbit\Tests\TestCase\TestCase;
use PHPUnit\Framework\Attributes\Test;

final class ColorSupportProbeTest extends TestCase
{
    #[Test]
    public function returnsTrueOnIsSupported(): void
    {
        self::assertTrue(ColorSupportProbe::isSupported());
    }

    #[Test]
    public function returnsCreatorClass(): void
    {
        self::assertSame(StylingMethodOptionCreator::class, ColorSupportProbe::getCreatorClass());
    }
}
