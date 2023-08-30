<?php

declare(strict_types=1);

namespace AlecRabbit\Tests\Functional\Spinner;

use AlecRabbit\Spinner\Core\Palette\Contract\ICharPalette;
use AlecRabbit\Spinner\Core\Palette\Contract\IPalette;
use AlecRabbit\Spinner\Core\Palette\Contract\IStylePalette;
use AlecRabbit\Spinner\Exception\InvalidArgumentException;
use AlecRabbit\Spinner\Palettes;
use AlecRabbit\Tests\Functional\Spinner\Override\CharPaletteOverride;
use AlecRabbit\Tests\Functional\Spinner\Override\PaletteOverride;
use AlecRabbit\Tests\Functional\Spinner\Override\StylePaletteOverride;
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
    public function canRegisterPalette(): void
    {
        $palette = PaletteOverride::class;
        Palettes::register($palette);

        $palettes = self::getPropertyValue('palettes', Palettes::class);
        self::assertContains($palette, $palettes);
    }

    #[Test]
    public function canLoadAllPalettes(): void
    {
        $palette1 = PaletteOverride::class;
        $palette2 = StylePaletteOverride::class;

        Palettes::register($palette2);
        Palettes::register($palette1);

        $palettes = iterator_to_array(Palettes::load());

        self::assertCount(2, $palettes);
        self::assertContains($palette1, $palettes);
        self::assertContains($palette2, $palettes);
    }

    #[Test]
    public function canRegisterMultiplePalettes(): void
    {
        $palette1 = PaletteOverride::class;
        $palette2 = StylePaletteOverride::class;
        $palette3 = CharPaletteOverride::class;

        Palettes::register($palette3);
        Palettes::register($palette2, $palette1);

        $palettes = iterator_to_array(Palettes::load());
        self::assertCount(3, $palettes);
        self::assertContains($palette1, $palettes);
        self::assertContains($palette2, $palettes);
        self::assertContains($palette3, $palettes);
    }

    #[Test]
    public function reRegisteringPaletteHasNoEffect(): void
    {
        $palette1 = PaletteOverride::class;
        $palette2 = StylePaletteOverride::class;
        $palette3 = CharPaletteOverride::class;

        Palettes::register($palette3);
        Palettes::register($palette2, $palette1);
        Palettes::register($palette1);
        Palettes::register($palette3);

        $palettes = iterator_to_array(Palettes::load());
        self::assertCount(3, $palettes);
        self::assertContains($palette1, $palettes);
        self::assertContains($palette2, $palettes);
        self::assertContains($palette3, $palettes);
    }

    #[Test]
    public function canLoadSpecificSubClassPalettes(): void
    {
        $palette1 = PaletteOverride::class;
        $palette2 = StylePaletteOverride::class;
        $palette3 = CharPaletteOverride::class;

        Palettes::register($palette2);
        Palettes::register($palette1);
        Palettes::register($palette3);

        $palettes = iterator_to_array(Palettes::load(IStylePalette::class));
        self::assertContains($palette2, $palettes);
        self::assertNotContains($palette1, $palettes);
        self::assertNotContains($palette3, $palettes);

        $palettes = iterator_to_array(Palettes::load(ICharPalette::class));
        self::assertContains($palette3, $palettes);
        self::assertNotContains($palette1, $palettes);
        self::assertNotContains($palette2, $palettes);
    }

    #[Test]
    public function canUnregisterSpecificPalette(): void
    {
        $palette1 = PaletteOverride::class;
        $palette2 = StylePaletteOverride::class;
        $palette3 = CharPaletteOverride::class;

        Palettes::register($palette2);
        Palettes::register($palette1);
        Palettes::register($palette3);

        Palettes::unregister($palette2);

        $palettes = iterator_to_array(Palettes::load());
        self::assertContains($palette1, $palettes);
        self::assertContains($palette3, $palettes);
        self::assertNotContains($palette2, $palettes);
    }

    #[Test]
    public function unregisteringNonRegisteredPaletteHasNoEffect(): void
    {
        $palette1 = PaletteOverride::class;
        $palette2 = StylePaletteOverride::class;
        $palette3 = CharPaletteOverride::class;

        Palettes::register($palette1);
        Palettes::register($palette3);

        Palettes::unregister($palette2);

        $palettes = iterator_to_array(Palettes::load());
        self::assertContains($palette1, $palettes);
        self::assertContains($palette3, $palettes);
        self::assertNotContains($palette2, $palettes);
    }

    #[Test]
    public function loadsAllPalettesIfFilterClassIsNull(): void
    {
        $palette1 = PaletteOverride::class;
        $palette2 = StylePaletteOverride::class;
        $palette3 = CharPaletteOverride::class;

        Palettes::register($palette3);
        Palettes::register($palette1);
        Palettes::register($palette2);

        $palettes = iterator_to_array(Palettes::load());
        self::assertContains($palette1, $palettes);
        self::assertContains($palette3, $palettes);
        self::assertContains($palette2, $palettes);
    }

    #[Test]
    public function throwsIfPaletteClassIsNotAPaletteSubClass(): void
    {
        $palette = \stdClass::class;
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage(
            'Class "' .
            $palette .
            '" must be a subclass of "' .
            IPalette::class .
            '" interface.'
        );
        Palettes::register($palette);
        self::fail('Exception was not thrown.');
    }


    #[Test]
    public function throwsIfFilterClassIsNotAStaticPaletteSubClass(): void
    {
        $filterClass = \stdClass::class;

        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage(
            'Class "' .
            $filterClass .
            '" must be a subclass of "' .
            IPalette::class .
            '" interface.'
        );

        Palettes::register(StylePaletteOverride::class);

        iterator_to_array(Palettes::load($filterClass));

        self::fail('Exception was not thrown.');
    }

    #[Test]
    public function throwsIfPaletteClassToUnregisterIsNotAPaletteSubClass(): void
    {
        $class = \stdClass::class;

        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage(
            'Class "' .
            $class .
            '" must be a subclass of "' .
            IPalette::class .
            '" interface.'
        );

        Palettes::unregister($class);

        self::fail('Exception was not thrown.');
    }

    #[Test]
    public function throwsIfPaletteClassIsNotAPaletteSubClass2(): void
    {
        $palette = '';
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage(
            'Class "' .
            $palette .
            '" must be a subclass of "' .
            IPalette::class .
            '" interface.'
        );
        Palettes::register($palette);
        self::fail('Exception was not thrown.');
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
