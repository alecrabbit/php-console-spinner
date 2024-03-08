<?php

declare(strict_types=1);

namespace AlecRabbit\Tests\Spinner\Unit\Core\Probe;

use AlecRabbit\Spinner\Core\Probe\StylingOptionCreator;
use AlecRabbit\Spinner\Core\Probe\StylingOptionProbe;
use AlecRabbit\Tests\TestCase\TestCase;
use PHPUnit\Framework\Attributes\Test;

final class StylingOptionProbeTest extends TestCase
{
    #[Test]
    public function returnsTrueOnIsSupported(): void
    {
        self::assertTrue(StylingOptionProbe::isSupported());
    }

    #[Test]
    public function returnsCreatorClass(): void
    {
        self::assertSame(StylingOptionCreator::class, StylingOptionProbe::getCreatorClass());
    }
}
