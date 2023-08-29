<?php

declare(strict_types=1);

namespace AlecRabbit\Tests\Functional\Spinner;

use AlecRabbit\Spinner\Palettes;
use AlecRabbit\Tests\Functional\Spinner\Override\PaletteOverride;
use AlecRabbit\Tests\TestCase\TestCase;
use PHPUnit\Framework\Attributes\Test;

final class PalettesTest extends TestCase
{
    private array $palettes = [];

//    #[Test]
//    public function canNotBeInstantiated(): void
//    {
//        $this->expectException(\Error::class);
//        $this->expectExceptionMessage('Call to private AlecRabbit\Spinner\Palettes::__construct()');
//        $palettes = new Palettes();
//    }

    #[Test]
    public function canRegisterProbe(): void
    {
        $palette = PaletteOverride::class;
        Palettes::register($palette);

        $palettes = self::getPropertyValue('palettes', Palettes::class);
        self::assertContains($palette, $palettes);
    }

    protected function setUp(): void
    {
        $this->palettes = self::getPropertyValue('palettes', Palettes::class);
        self::setPropertyValue(Palettes::class, 'palettes', []);
    }

    protected function tearDown(): void
    {
        self::setPropertyValue(Palettes::class, 'palettes', $this->palettes);
    }
}
