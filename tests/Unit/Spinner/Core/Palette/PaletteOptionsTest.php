<?php

declare(strict_types=1);

namespace AlecRabbit\Tests\Unit\Spinner\Core\Palette;

use AlecRabbit\Spinner\Core\Palette\Contract\IPaletteOptions;
use AlecRabbit\Spinner\Core\Palette\PaletteOptions;
use AlecRabbit\Tests\TestCase\TestCase;
use PHPUnit\Framework\Attributes\Test;

final class PaletteOptionsTest extends TestCase
{
    #[Test]
    public function canBeInstantiated(): void
    {
        $palette = $this->getTesteeInstance();

        self::assertInstanceOf(PaletteOptions::class, $palette);
    }

    private function getTesteeInstance(
        ?int $interval = null,
        ?bool $reversed = null,
    ): IPaletteOptions {
        return
            new PaletteOptions(
                interval: $interval,
                reversed: $reversed,
            );
    }

    #[Test]
    public function canGetIsReversedWithNull(): void
    {
        $palette = $this->getTesteeInstance();

        self::assertNull($palette->getReversed());
    }

    #[Test]
    public function canGetIsReversedWithTrue(): void
    {
        $palette = $this->getTesteeInstance(
            reversed: true,
        );

        self::assertTrue($palette->getReversed());
    }

    #[Test]
    public function canGetIsReversedWithFalse(): void
    {
        $palette = $this->getTesteeInstance(
            reversed: false,
        );

        self::assertFalse($palette->getReversed());
    }

    #[Test]
    public function canGetIntervalWithNull(): void
    {
        $palette = $this->getTesteeInstance();

        self::assertNull($palette->getInterval());
    }

    #[Test]
    public function canGetIntervalWithNumber(): void
    {
        $interval = 100;
        $palette = $this->getTesteeInstance(
            interval: $interval,
        );

        self::assertSame($interval, $palette->getInterval());
    }
}
