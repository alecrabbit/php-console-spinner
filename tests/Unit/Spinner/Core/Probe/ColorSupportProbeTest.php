<?php

declare(strict_types=1);

namespace AlecRabbit\Tests\Unit\Spinner\Core\Probe;

use AlecRabbit\Spinner\Contract\Option\StylingMethodOption;
use AlecRabbit\Spinner\Core\Probe\ColorSupportProbe;
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
    public function returnsAutoOnGetStylingMethodOption(): void
    {
        self::assertSame(StylingMethodOption::AUTO, ColorSupportProbe::getStylingMethodOption());
    }
}
