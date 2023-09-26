<?php

declare(strict_types=1);

namespace AlecRabbit\Tests\Unit\Spinner\Core\Palette;

use AlecRabbit\Spinner\Contract\Mode\StylingMethodMode;
use AlecRabbit\Spinner\Core\Palette\Contract\IPalette;
use AlecRabbit\Spinner\Core\Palette\Contract\IPaletteMode;
use AlecRabbit\Spinner\Core\Palette\Contract\IPaletteOptions;
use AlecRabbit\Spinner\Core\Palette\Rainbow;
use AlecRabbit\Spinner\Core\StyleFrame;
use AlecRabbit\Tests\TestCase\TestCase;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\MockObject\MockObject;

final class RainbowTest extends TestCase
{
    #[Test]
    public function canBeInstantiated(): void
    {
        $palette = $this->getTesteeInstance();

        self::assertInstanceOf(Rainbow::class, $palette);
    }

    private function getTesteeInstance(
        ?IPaletteOptions $options = null,
    ): IPalette {
        return
            new Rainbow(
                options: $options ?? $this->getPaletteOptionsMock(),
            );
    }

    private function getPaletteOptionsMock(): MockObject&IPaletteOptions
    {
        return $this->createMock(IPaletteOptions::class);
    }

    #[Test]
    public function canGetEntriesWithMode(): void
    {
        $palette = $this->getTesteeInstance();

        $mode = $this->getPaletteModeMock();

        $entries = $palette->getEntries($mode);

        self::assertInstanceOf(\Generator::class, $entries);
    }

    private function getPaletteModeMock(): MockObject&IPaletteMode
    {
        return $this->createMock(IPaletteMode::class);
    }

    #[Test]
    public function canGetEntriesWithoutMode(): void
    {
        $palette = $this->getTesteeInstance();

        $entries = $palette->getEntries();

        self::assertInstanceOf(\Generator::class, $entries);
    }

    #[Test]
    public function returnsOneFrameIteratorWithoutMode(): void
    {
        $palette = $this->getTesteeInstance();

        $traversable = $palette->getEntries();

        self::assertInstanceOf(\Generator::class, $traversable);

        $entries = iterator_to_array($traversable); // unwrap generator

        self::assertCount(1, $entries);
        self::assertEquals(new StyleFrame('%s', 0), $entries[0]);
    }

    #[Test]
    public function returnsOneFrameIteratorOnStylingModeNone(): void
    {
        $palette = $this->getTesteeInstance();

        $mode = $this->getPaletteModeMock();
        $mode
            ->expects(self::once())
            ->method('getStylingMode')
            ->willReturn(StylingMethodMode::NONE)
        ;

        $traversable = $palette->getEntries($mode);

        self::assertInstanceOf(\Generator::class, $traversable);

        $entries = iterator_to_array($traversable); // unwrap generator

        self::assertCount(1, $entries);
        self::assertEquals(new StyleFrame('%s', 0), $entries[0]);
    }

    #[Test]
    public function returnsOneFrameIteratorOnStylingModeANSI4(): void
    {
        $options = $this->getPaletteOptionsMock();

        $palette = $this->getTesteeInstance(
            options: $options
        );

        $mode = $this->getPaletteModeMock();
        $mode
            ->expects(self::once())
            ->method('getStylingMode')
            ->willReturn(StylingMethodMode::ANSI4)
        ;

        $traversable = $palette->getEntries($mode);

        self::assertInstanceOf(\Generator::class, $traversable);

        $entries = iterator_to_array($traversable); // unwrap generator

        self::assertCount(1, $entries);
        self::assertEquals(new StyleFrame("\e[96m%s\e[39m", 0), $entries[0]);

        self::assertNull($palette->getOptions()->getInterval());
        self::assertNull($palette->getOptions()->getReversed());
    }

    #[Test]
    public function returnsFramesOnStylingModeANSI8(): void
    {
        $options = $this->getPaletteOptionsMock();

        $palette = $this->getTesteeInstance(
            options: $options
        );

        $mode = $this->getPaletteModeMock();
        $mode
            ->expects(self::once())
            ->method('getStylingMode')
            ->willReturn(StylingMethodMode::ANSI8)
        ;

        $traversable = $palette->getEntries($mode);

        self::assertInstanceOf(\Generator::class, $traversable);

        $entries = iterator_to_array($traversable); // unwrap generator

        self::assertCount(29, $entries);

        self::assertSame(1000, $palette->getOptions()->getInterval());
        self::assertNull($palette->getOptions()->getReversed());

        self::assertEquals(new StyleFrame("\e[38;5;196m%s\e[39m", 0), $entries[0]);
        self::assertEquals(new StyleFrame("\e[38;5;208m%s\e[39m", 0), $entries[1]);
        self::assertEquals(new StyleFrame("\e[38;5;214m%s\e[39m", 0), $entries[2]);
        self::assertEquals(new StyleFrame("\e[38;5;220m%s\e[39m", 0), $entries[3]);
        self::assertEquals(new StyleFrame("\e[38;5;226m%s\e[39m", 0), $entries[4]);
        self::assertEquals(new StyleFrame("\e[38;5;190m%s\e[39m", 0), $entries[5]);
        self::assertEquals(new StyleFrame("\e[38;5;154m%s\e[39m", 0), $entries[6]);
        self::assertEquals(new StyleFrame("\e[38;5;118m%s\e[39m", 0), $entries[7]);
        self::assertEquals(new StyleFrame("\e[38;5;82m%s\e[39m", 0), $entries[8]);
        self::assertEquals(new StyleFrame("\e[38;5;46m%s\e[39m", 0), $entries[9]);
        self::assertEquals(new StyleFrame("\e[38;5;47m%s\e[39m", 0), $entries[10]);
        self::assertEquals(new StyleFrame("\e[38;5;48m%s\e[39m", 0), $entries[11]);
        self::assertEquals(new StyleFrame("\e[38;5;49m%s\e[39m", 0), $entries[12]);
        self::assertEquals(new StyleFrame("\e[38;5;50m%s\e[39m", 0), $entries[13]);
        self::assertEquals(new StyleFrame("\e[38;5;51m%s\e[39m", 0), $entries[14]);
        self::assertEquals(new StyleFrame("\e[38;5;45m%s\e[39m", 0), $entries[15]);
        self::assertEquals(new StyleFrame("\e[38;5;39m%s\e[39m", 0), $entries[16]);
        self::assertEquals(new StyleFrame("\e[38;5;33m%s\e[39m", 0), $entries[17]);
        self::assertEquals(new StyleFrame("\e[38;5;27m%s\e[39m", 0), $entries[18]);
        self::assertEquals(new StyleFrame("\e[38;5;56m%s\e[39m", 0), $entries[19]);
        self::assertEquals(new StyleFrame("\e[38;5;57m%s\e[39m", 0), $entries[20]);
        self::assertEquals(new StyleFrame("\e[38;5;93m%s\e[39m", 0), $entries[21]);
        self::assertEquals(new StyleFrame("\e[38;5;129m%s\e[39m", 0), $entries[22]);
        self::assertEquals(new StyleFrame("\e[38;5;165m%s\e[39m", 0), $entries[23]);
        self::assertEquals(new StyleFrame("\e[38;5;201m%s\e[39m", 0), $entries[24]);
        self::assertEquals(new StyleFrame("\e[38;5;200m%s\e[39m", 0), $entries[25]);
        self::assertEquals(new StyleFrame("\e[38;5;199m%s\e[39m", 0), $entries[26]);
        self::assertEquals(new StyleFrame("\e[38;5;198m%s\e[39m", 0), $entries[27]);
        self::assertEquals(new StyleFrame("\e[38;5;197m%s\e[39m", 0), $entries[28]);
    }

    #[Test]
    public function returnsFramesOnStylingModeANSI8AndCustomOptions(): void
    {
        $interval = 85;
        $options = $this->getPaletteOptionsMock();
        $options
            ->expects(self::once())
            ->method('getInterval')
            ->willReturn($interval)
        ;
        $options
            ->expects(self::once())
            ->method('getReversed')
            ->willReturn(true)
        ;

        $palette = $this->getTesteeInstance(
            options: $options
        );

        $mode = $this->getPaletteModeMock();
        $mode
            ->expects(self::once())
            ->method('getStylingMode')
            ->willReturn(StylingMethodMode::ANSI8)
        ;

        $traversable = $palette->getEntries($mode);

        self::assertInstanceOf(\Generator::class, $traversable);

        $entries = iterator_to_array($traversable); // unwrap generator

        self::assertCount(29, $entries);

        self::assertSame($interval, $palette->getOptions()->getInterval());
        self::assertTrue($palette->getOptions()->getReversed());

        self::assertEquals(new StyleFrame("\e[38;5;196m%s\e[39m", 0), $entries[28]);
        self::assertEquals(new StyleFrame("\e[38;5;208m%s\e[39m", 0), $entries[27]);
        self::assertEquals(new StyleFrame("\e[38;5;214m%s\e[39m", 0), $entries[26]);
        self::assertEquals(new StyleFrame("\e[38;5;220m%s\e[39m", 0), $entries[25]);
        self::assertEquals(new StyleFrame("\e[38;5;226m%s\e[39m", 0), $entries[24]);
        self::assertEquals(new StyleFrame("\e[38;5;190m%s\e[39m", 0), $entries[23]);
        self::assertEquals(new StyleFrame("\e[38;5;154m%s\e[39m", 0), $entries[22]);
        self::assertEquals(new StyleFrame("\e[38;5;118m%s\e[39m", 0), $entries[21]);
        self::assertEquals(new StyleFrame("\e[38;5;82m%s\e[39m", 0), $entries[20]);
        self::assertEquals(new StyleFrame("\e[38;5;46m%s\e[39m", 0), $entries[19]);
        self::assertEquals(new StyleFrame("\e[38;5;47m%s\e[39m", 0), $entries[18]);
        self::assertEquals(new StyleFrame("\e[38;5;48m%s\e[39m", 0), $entries[17]);
        self::assertEquals(new StyleFrame("\e[38;5;49m%s\e[39m", 0), $entries[16]);
        self::assertEquals(new StyleFrame("\e[38;5;50m%s\e[39m", 0), $entries[15]);
        self::assertEquals(new StyleFrame("\e[38;5;51m%s\e[39m", 0), $entries[14]);
        self::assertEquals(new StyleFrame("\e[38;5;45m%s\e[39m", 0), $entries[13]);
        self::assertEquals(new StyleFrame("\e[38;5;39m%s\e[39m", 0), $entries[12]);
        self::assertEquals(new StyleFrame("\e[38;5;33m%s\e[39m", 0), $entries[11]);
        self::assertEquals(new StyleFrame("\e[38;5;27m%s\e[39m", 0), $entries[10]);
        self::assertEquals(new StyleFrame("\e[38;5;56m%s\e[39m", 0), $entries[9]);
        self::assertEquals(new StyleFrame("\e[38;5;57m%s\e[39m", 0), $entries[8]);
        self::assertEquals(new StyleFrame("\e[38;5;93m%s\e[39m", 0), $entries[7]);
        self::assertEquals(new StyleFrame("\e[38;5;129m%s\e[39m", 0), $entries[6]);
        self::assertEquals(new StyleFrame("\e[38;5;165m%s\e[39m", 0), $entries[5]);
        self::assertEquals(new StyleFrame("\e[38;5;201m%s\e[39m", 0), $entries[4]);
        self::assertEquals(new StyleFrame("\e[38;5;200m%s\e[39m", 0), $entries[3]);
        self::assertEquals(new StyleFrame("\e[38;5;199m%s\e[39m", 0), $entries[2]);
        self::assertEquals(new StyleFrame("\e[38;5;198m%s\e[39m", 0), $entries[1]);
        self::assertEquals(new StyleFrame("\e[38;5;197m%s\e[39m", 0), $entries[0]);
    }

    #[Test]
    public function returnsFramesOnStylingModeANSI24(): void
    {
        $options = $this->getPaletteOptionsMock();

        $palette = $this->getTesteeInstance(
            options: $options
        );

        $mode = $this->getPaletteModeMock();
        $mode
            ->expects(self::once())
            ->method('getStylingMode')
            ->willReturn(StylingMethodMode::ANSI24)
        ;

        $traversable = $palette->getEntries($mode);

        self::assertInstanceOf(\Generator::class, $traversable);

        $entries = iterator_to_array($traversable); // unwrap generator

        self::assertCount(360, $entries);

        self::assertSame(100, $palette->getOptions()->getInterval());
        self::assertNull($palette->getOptions()->getReversed());

        self::assertEquals(new StyleFrame("\e[38;2;255;0;0m%s\e[39m", 0), $entries[0]);
        self::assertEquals(new StyleFrame("\e[38;2;255;4;0m%s\e[39m", 0), $entries[1]);
        self::assertEquals(new StyleFrame("\e[38;2;255;8;0m%s\e[39m", 0), $entries[2]);
        self::assertEquals(new StyleFrame("\e[38;2;255;12;0m%s\e[39m", 0), $entries[3]);
        self::assertEquals(new StyleFrame("\e[38;2;255;16;0m%s\e[39m", 0), $entries[4]);
        self::assertEquals(new StyleFrame("\e[38;2;255;21;0m%s\e[39m", 0), $entries[5]);
        self::assertEquals(new StyleFrame("\e[38;2;255;25;0m%s\e[39m", 0), $entries[6]);
        self::assertEquals(new StyleFrame("\e[38;2;255;29;0m%s\e[39m", 0), $entries[7]);
        self::assertEquals(new StyleFrame("\e[38;2;255;33;0m%s\e[39m", 0), $entries[8]);
        self::assertEquals(new StyleFrame("\e[38;2;255;38;0m%s\e[39m", 0), $entries[9]);
        self::assertEquals(new StyleFrame("\e[38;2;255;42;0m%s\e[39m", 0), $entries[10]);
        self::assertEquals(new StyleFrame("\e[38;2;255;46;0m%s\e[39m", 0), $entries[11]);
        self::assertEquals(new StyleFrame("\e[38;2;255;50;0m%s\e[39m", 0), $entries[12]);
        self::assertEquals(new StyleFrame("\e[38;2;255;55;0m%s\e[39m", 0), $entries[13]);
        self::assertEquals(new StyleFrame("\e[38;2;255;59;0m%s\e[39m", 0), $entries[14]);
        self::assertEquals(new StyleFrame("\e[38;2;255;63;0m%s\e[39m", 0), $entries[15]);
        self::assertEquals(new StyleFrame("\e[38;2;255;67;0m%s\e[39m", 0), $entries[16]);
        self::assertEquals(new StyleFrame("\e[38;2;255;72;0m%s\e[39m", 0), $entries[17]);
        self::assertEquals(new StyleFrame("\e[38;2;255;76;0m%s\e[39m", 0), $entries[18]);
        self::assertEquals(new StyleFrame("\e[38;2;255;80;0m%s\e[39m", 0), $entries[19]);
        self::assertEquals(new StyleFrame("\e[38;2;255;84;0m%s\e[39m", 0), $entries[20]);
        self::assertEquals(new StyleFrame("\e[38;2;255;89;0m%s\e[39m", 0), $entries[21]);
        self::assertEquals(new StyleFrame("\e[38;2;255;93;0m%s\e[39m", 0), $entries[22]);
        self::assertEquals(new StyleFrame("\e[38;2;255;97;0m%s\e[39m", 0), $entries[23]);
        self::assertEquals(new StyleFrame("\e[38;2;255;102;0m%s\e[39m", 0), $entries[24]);
        self::assertEquals(new StyleFrame("\e[38;2;255;106;0m%s\e[39m", 0), $entries[25]);
        self::assertEquals(new StyleFrame("\e[38;2;255;110;0m%s\e[39m", 0), $entries[26]);
        self::assertEquals(new StyleFrame("\e[38;2;255;114;0m%s\e[39m", 0), $entries[27]);
        self::assertEquals(new StyleFrame("\e[38;2;255;119;0m%s\e[39m", 0), $entries[28]);
        self::assertEquals(new StyleFrame("\e[38;2;255;123;0m%s\e[39m", 0), $entries[29]);
        self::assertEquals(new StyleFrame("\e[38;2;255;127;0m%s\e[39m", 0), $entries[30]);
        self::assertEquals(new StyleFrame("\e[38;2;255;131;0m%s\e[39m", 0), $entries[31]);
        self::assertEquals(new StyleFrame("\e[38;2;255;136;0m%s\e[39m", 0), $entries[32]);
        self::assertEquals(new StyleFrame("\e[38;2;255;140;0m%s\e[39m", 0), $entries[33]);
        self::assertEquals(new StyleFrame("\e[38;2;255;144;0m%s\e[39m", 0), $entries[34]);
        self::assertEquals(new StyleFrame("\e[38;2;255;148;0m%s\e[39m", 0), $entries[35]);
        self::assertEquals(new StyleFrame("\e[38;2;255;153;0m%s\e[39m", 0), $entries[36]);
        self::assertEquals(new StyleFrame("\e[38;2;255;157;0m%s\e[39m", 0), $entries[37]);
        self::assertEquals(new StyleFrame("\e[38;2;255;161;0m%s\e[39m", 0), $entries[38]);
        self::assertEquals(new StyleFrame("\e[38;2;255;165;0m%s\e[39m", 0), $entries[39]);
        self::assertEquals(new StyleFrame("\e[38;2;255;170;0m%s\e[39m", 0), $entries[40]);
        self::assertEquals(new StyleFrame("\e[38;2;255;174;0m%s\e[39m", 0), $entries[41]);
        self::assertEquals(new StyleFrame("\e[38;2;255;178;0m%s\e[39m", 0), $entries[42]);
        self::assertEquals(new StyleFrame("\e[38;2;255;182;0m%s\e[39m", 0), $entries[43]);
        self::assertEquals(new StyleFrame("\e[38;2;255;187;0m%s\e[39m", 0), $entries[44]);
        self::assertEquals(new StyleFrame("\e[38;2;255;191;0m%s\e[39m", 0), $entries[45]);
        self::assertEquals(new StyleFrame("\e[38;2;255;195;0m%s\e[39m", 0), $entries[46]);
        self::assertEquals(new StyleFrame("\e[38;2;255;199;0m%s\e[39m", 0), $entries[47]);
        self::assertEquals(new StyleFrame("\e[38;2;255;204;0m%s\e[39m", 0), $entries[48]);
        self::assertEquals(new StyleFrame("\e[38;2;255;208;0m%s\e[39m", 0), $entries[49]);
        self::assertEquals(new StyleFrame("\e[38;2;255;212;0m%s\e[39m", 0), $entries[50]);
        self::assertEquals(new StyleFrame("\e[38;2;255;216;0m%s\e[39m", 0), $entries[51]);
        self::assertEquals(new StyleFrame("\e[38;2;255;220;0m%s\e[39m", 0), $entries[52]);
        self::assertEquals(new StyleFrame("\e[38;2;255;225;0m%s\e[39m", 0), $entries[53]);
        self::assertEquals(new StyleFrame("\e[38;2;255;229;0m%s\e[39m", 0), $entries[54]);
        self::assertEquals(new StyleFrame("\e[38;2;255;233;0m%s\e[39m", 0), $entries[55]);
        self::assertEquals(new StyleFrame("\e[38;2;255;238;0m%s\e[39m", 0), $entries[56]);
        self::assertEquals(new StyleFrame("\e[38;2;255;242;0m%s\e[39m", 0), $entries[57]);
        self::assertEquals(new StyleFrame("\e[38;2;255;246;0m%s\e[39m", 0), $entries[58]);
        self::assertEquals(new StyleFrame("\e[38;2;255;250;0m%s\e[39m", 0), $entries[59]);
        self::assertEquals(new StyleFrame("\e[38;2;255;255;0m%s\e[39m", 0), $entries[60]);
        self::assertEquals(new StyleFrame("\e[38;2;250;255;0m%s\e[39m", 0), $entries[61]);
        self::assertEquals(new StyleFrame("\e[38;2;246;255;0m%s\e[39m", 0), $entries[62]);
        self::assertEquals(new StyleFrame("\e[38;2;242;255;0m%s\e[39m", 0), $entries[63]);
        self::assertEquals(new StyleFrame("\e[38;2;238;255;0m%s\e[39m", 0), $entries[64]);
        self::assertEquals(new StyleFrame("\e[38;2;233;255;0m%s\e[39m", 0), $entries[65]);
        self::assertEquals(new StyleFrame("\e[38;2;229;255;0m%s\e[39m", 0), $entries[66]);
        self::assertEquals(new StyleFrame("\e[38;2;225;255;0m%s\e[39m", 0), $entries[67]);
        self::assertEquals(new StyleFrame("\e[38;2;221;255;0m%s\e[39m", 0), $entries[68]);
        self::assertEquals(new StyleFrame("\e[38;2;216;255;0m%s\e[39m", 0), $entries[69]);
        self::assertEquals(new StyleFrame("\e[38;2;212;255;0m%s\e[39m", 0), $entries[70]);
        self::assertEquals(new StyleFrame("\e[38;2;208;255;0m%s\e[39m", 0), $entries[71]);
        self::assertEquals(new StyleFrame("\e[38;2;203;255;0m%s\e[39m", 0), $entries[72]);
        self::assertEquals(new StyleFrame("\e[38;2;199;255;0m%s\e[39m", 0), $entries[73]);
        self::assertEquals(new StyleFrame("\e[38;2;195;255;0m%s\e[39m", 0), $entries[74]);
        self::assertEquals(new StyleFrame("\e[38;2;191;255;0m%s\e[39m", 0), $entries[75]);
        self::assertEquals(new StyleFrame("\e[38;2;187;255;0m%s\e[39m", 0), $entries[76]);
        self::assertEquals(new StyleFrame("\e[38;2;182;255;0m%s\e[39m", 0), $entries[77]);
        self::assertEquals(new StyleFrame("\e[38;2;178;255;0m%s\e[39m", 0), $entries[78]);
        self::assertEquals(new StyleFrame("\e[38;2;174;255;0m%s\e[39m", 0), $entries[79]);
        self::assertEquals(new StyleFrame("\e[38;2;170;255;0m%s\e[39m", 0), $entries[80]);
        self::assertEquals(new StyleFrame("\e[38;2;165;255;0m%s\e[39m", 0), $entries[81]);
        self::assertEquals(new StyleFrame("\e[38;2;161;255;0m%s\e[39m", 0), $entries[82]);
        self::assertEquals(new StyleFrame("\e[38;2;157;255;0m%s\e[39m", 0), $entries[83]);
        self::assertEquals(new StyleFrame("\e[38;2;153;255;0m%s\e[39m", 0), $entries[84]);
        self::assertEquals(new StyleFrame("\e[38;2;148;255;0m%s\e[39m", 0), $entries[85]);
        self::assertEquals(new StyleFrame("\e[38;2;144;255;0m%s\e[39m", 0), $entries[86]);
        self::assertEquals(new StyleFrame("\e[38;2;140;255;0m%s\e[39m", 0), $entries[87]);
        self::assertEquals(new StyleFrame("\e[38;2;136;255;0m%s\e[39m", 0), $entries[88]);
        self::assertEquals(new StyleFrame("\e[38;2;131;255;0m%s\e[39m", 0), $entries[89]);
        self::assertEquals(new StyleFrame("\e[38;2;127;255;0m%s\e[39m", 0), $entries[90]);
        self::assertEquals(new StyleFrame("\e[38;2;123;255;0m%s\e[39m", 0), $entries[91]);
        self::assertEquals(new StyleFrame("\e[38;2;119;255;0m%s\e[39m", 0), $entries[92]);
        self::assertEquals(new StyleFrame("\e[38;2;114;255;0m%s\e[39m", 0), $entries[93]);
        self::assertEquals(new StyleFrame("\e[38;2;110;255;0m%s\e[39m", 0), $entries[94]);
        self::assertEquals(new StyleFrame("\e[38;2;106;255;0m%s\e[39m", 0), $entries[95]);
        self::assertEquals(new StyleFrame("\e[38;2;101;255;0m%s\e[39m", 0), $entries[96]);
        self::assertEquals(new StyleFrame("\e[38;2;97;255;0m%s\e[39m", 0), $entries[97]);
        self::assertEquals(new StyleFrame("\e[38;2;93;255;0m%s\e[39m", 0), $entries[98]);
        self::assertEquals(new StyleFrame("\e[38;2;89;255;0m%s\e[39m", 0), $entries[99]);
        self::assertEquals(new StyleFrame("\e[38;2;84;255;0m%s\e[39m", 0), $entries[100]);
        self::assertEquals(new StyleFrame("\e[38;2;80;255;0m%s\e[39m", 0), $entries[101]);
        self::assertEquals(new StyleFrame("\e[38;2;76;255;0m%s\e[39m", 0), $entries[102]);
        self::assertEquals(new StyleFrame("\e[38;2;72;255;0m%s\e[39m", 0), $entries[103]);
        self::assertEquals(new StyleFrame("\e[38;2;68;255;0m%s\e[39m", 0), $entries[104]);
        self::assertEquals(new StyleFrame("\e[38;2;63;255;0m%s\e[39m", 0), $entries[105]);
        self::assertEquals(new StyleFrame("\e[38;2;59;255;0m%s\e[39m", 0), $entries[106]);
        self::assertEquals(new StyleFrame("\e[38;2;55;255;0m%s\e[39m", 0), $entries[107]);
        self::assertEquals(new StyleFrame("\e[38;2;51;255;0m%s\e[39m", 0), $entries[108]);
        self::assertEquals(new StyleFrame("\e[38;2;46;255;0m%s\e[39m", 0), $entries[109]);
        self::assertEquals(new StyleFrame("\e[38;2;42;255;0m%s\e[39m", 0), $entries[110]);
        self::assertEquals(new StyleFrame("\e[38;2;38;255;0m%s\e[39m", 0), $entries[111]);
        self::assertEquals(new StyleFrame("\e[38;2;33;255;0m%s\e[39m", 0), $entries[112]);
        self::assertEquals(new StyleFrame("\e[38;2;29;255;0m%s\e[39m", 0), $entries[113]);
        self::assertEquals(new StyleFrame("\e[38;2;25;255;0m%s\e[39m", 0), $entries[114]);
        self::assertEquals(new StyleFrame("\e[38;2;21;255;0m%s\e[39m", 0), $entries[115]);
        self::assertEquals(new StyleFrame("\e[38;2;16;255;0m%s\e[39m", 0), $entries[116]);
        self::assertEquals(new StyleFrame("\e[38;2;12;255;0m%s\e[39m", 0), $entries[117]);
        self::assertEquals(new StyleFrame("\e[38;2;8;255;0m%s\e[39m", 0), $entries[118]);
        self::assertEquals(new StyleFrame("\e[38;2;4;255;0m%s\e[39m", 0), $entries[119]);
        self::assertEquals(new StyleFrame("\e[38;2;0;255;0m%s\e[39m", 0), $entries[120]);
        self::assertEquals(new StyleFrame("\e[38;2;0;255;4m%s\e[39m", 0), $entries[121]);
        self::assertEquals(new StyleFrame("\e[38;2;0;255;8m%s\e[39m", 0), $entries[122]);
        self::assertEquals(new StyleFrame("\e[38;2;0;255;12m%s\e[39m", 0), $entries[123]);
        self::assertEquals(new StyleFrame("\e[38;2;0;255;16m%s\e[39m", 0), $entries[124]);
        self::assertEquals(new StyleFrame("\e[38;2;0;255;21m%s\e[39m", 0), $entries[125]);
        self::assertEquals(new StyleFrame("\e[38;2;0;255;25m%s\e[39m", 0), $entries[126]);
        self::assertEquals(new StyleFrame("\e[38;2;0;255;29m%s\e[39m", 0), $entries[127]);
        self::assertEquals(new StyleFrame("\e[38;2;0;255;33m%s\e[39m", 0), $entries[128]);
        self::assertEquals(new StyleFrame("\e[38;2;0;255;38m%s\e[39m", 0), $entries[129]);
        self::assertEquals(new StyleFrame("\e[38;2;0;255;42m%s\e[39m", 0), $entries[130]);
        self::assertEquals(new StyleFrame("\e[38;2;0;255;46m%s\e[39m", 0), $entries[131]);
        self::assertEquals(new StyleFrame("\e[38;2;0;255;50m%s\e[39m", 0), $entries[132]);
        self::assertEquals(new StyleFrame("\e[38;2;0;255;55m%s\e[39m", 0), $entries[133]);
        self::assertEquals(new StyleFrame("\e[38;2;0;255;59m%s\e[39m", 0), $entries[134]);
        self::assertEquals(new StyleFrame("\e[38;2;0;255;63m%s\e[39m", 0), $entries[135]);
        self::assertEquals(new StyleFrame("\e[38;2;0;255;67m%s\e[39m", 0), $entries[136]);
        self::assertEquals(new StyleFrame("\e[38;2;0;255;72m%s\e[39m", 0), $entries[137]);
        self::assertEquals(new StyleFrame("\e[38;2;0;255;76m%s\e[39m", 0), $entries[138]);
        self::assertEquals(new StyleFrame("\e[38;2;0;255;80m%s\e[39m", 0), $entries[139]);
        self::assertEquals(new StyleFrame("\e[38;2;0;255;85m%s\e[39m", 0), $entries[140]);
        self::assertEquals(new StyleFrame("\e[38;2;0;255;89m%s\e[39m", 0), $entries[141]);
        self::assertEquals(new StyleFrame("\e[38;2;0;255;93m%s\e[39m", 0), $entries[142]);
        self::assertEquals(new StyleFrame("\e[38;2;0;255;97m%s\e[39m", 0), $entries[143]);
        self::assertEquals(new StyleFrame("\e[38;2;0;255;102m%s\e[39m", 0), $entries[144]);
        self::assertEquals(new StyleFrame("\e[38;2;0;255;106m%s\e[39m", 0), $entries[145]);
        self::assertEquals(new StyleFrame("\e[38;2;0;255;110m%s\e[39m", 0), $entries[146]);
        self::assertEquals(new StyleFrame("\e[38;2;0;255;114m%s\e[39m", 0), $entries[147]);
        self::assertEquals(new StyleFrame("\e[38;2;0;255;119m%s\e[39m", 0), $entries[148]);
        self::assertEquals(new StyleFrame("\e[38;2;0;255;123m%s\e[39m", 0), $entries[149]);
        self::assertEquals(new StyleFrame("\e[38;2;0;255;127m%s\e[39m", 0), $entries[150]);
        self::assertEquals(new StyleFrame("\e[38;2;0;255;131m%s\e[39m", 0), $entries[151]);
        self::assertEquals(new StyleFrame("\e[38;2;0;255;135m%s\e[39m", 0), $entries[152]);
        self::assertEquals(new StyleFrame("\e[38;2;0;255;140m%s\e[39m", 0), $entries[153]);
        self::assertEquals(new StyleFrame("\e[38;2;0;255;144m%s\e[39m", 0), $entries[154]);
        self::assertEquals(new StyleFrame("\e[38;2;0;255;148m%s\e[39m", 0), $entries[155]);
        self::assertEquals(new StyleFrame("\e[38;2;0;255;153m%s\e[39m", 0), $entries[156]);
        self::assertEquals(new StyleFrame("\e[38;2;0;255;157m%s\e[39m", 0), $entries[157]);
        self::assertEquals(new StyleFrame("\e[38;2;0;255;161m%s\e[39m", 0), $entries[158]);
        self::assertEquals(new StyleFrame("\e[38;2;0;255;165m%s\e[39m", 0), $entries[159]);
        self::assertEquals(new StyleFrame("\e[38;2;0;255;169m%s\e[39m", 0), $entries[160]);
        self::assertEquals(new StyleFrame("\e[38;2;0;255;174m%s\e[39m", 0), $entries[161]);
        self::assertEquals(new StyleFrame("\e[38;2;0;255;178m%s\e[39m", 0), $entries[162]);
        self::assertEquals(new StyleFrame("\e[38;2;0;255;182m%s\e[39m", 0), $entries[163]);
        self::assertEquals(new StyleFrame("\e[38;2;0;255;187m%s\e[39m", 0), $entries[164]);
        self::assertEquals(new StyleFrame("\e[38;2;0;255;191m%s\e[39m", 0), $entries[165]);
        self::assertEquals(new StyleFrame("\e[38;2;0;255;195m%s\e[39m", 0), $entries[166]);
        self::assertEquals(new StyleFrame("\e[38;2;0;255;199m%s\e[39m", 0), $entries[167]);
        self::assertEquals(new StyleFrame("\e[38;2;0;255;203m%s\e[39m", 0), $entries[168]);
        self::assertEquals(new StyleFrame("\e[38;2;0;255;208m%s\e[39m", 0), $entries[169]);
        self::assertEquals(new StyleFrame("\e[38;2;0;255;212m%s\e[39m", 0), $entries[170]);
        self::assertEquals(new StyleFrame("\e[38;2;0;255;216m%s\e[39m", 0), $entries[171]);
        self::assertEquals(new StyleFrame("\e[38;2;0;255;221m%s\e[39m", 0), $entries[172]);
        self::assertEquals(new StyleFrame("\e[38;2;0;255;225m%s\e[39m", 0), $entries[173]);
        self::assertEquals(new StyleFrame("\e[38;2;0;255;229m%s\e[39m", 0), $entries[174]);
        self::assertEquals(new StyleFrame("\e[38;2;0;255;233m%s\e[39m", 0), $entries[175]);
        self::assertEquals(new StyleFrame("\e[38;2;0;255;237m%s\e[39m", 0), $entries[176]);
        self::assertEquals(new StyleFrame("\e[38;2;0;255;242m%s\e[39m", 0), $entries[177]);
        self::assertEquals(new StyleFrame("\e[38;2;0;255;246m%s\e[39m", 0), $entries[178]);
        self::assertEquals(new StyleFrame("\e[38;2;0;255;250m%s\e[39m", 0), $entries[179]);
        self::assertEquals(new StyleFrame("\e[38;2;0;255;255m%s\e[39m", 0), $entries[180]);
        self::assertEquals(new StyleFrame("\e[38;2;0;250;255m%s\e[39m", 0), $entries[181]);
        self::assertEquals(new StyleFrame("\e[38;2;0;246;255m%s\e[39m", 0), $entries[182]);
        self::assertEquals(new StyleFrame("\e[38;2;0;242;255m%s\e[39m", 0), $entries[183]);
        self::assertEquals(new StyleFrame("\e[38;2;0;238;255m%s\e[39m", 0), $entries[184]);
        self::assertEquals(new StyleFrame("\e[38;2;0;233;255m%s\e[39m", 0), $entries[185]);
        self::assertEquals(new StyleFrame("\e[38;2;0;229;255m%s\e[39m", 0), $entries[186]);
        self::assertEquals(new StyleFrame("\e[38;2;0;225;255m%s\e[39m", 0), $entries[187]);
        self::assertEquals(new StyleFrame("\e[38;2;0;220;255m%s\e[39m", 0), $entries[188]);
        self::assertEquals(new StyleFrame("\e[38;2;0;216;255m%s\e[39m", 0), $entries[189]);
        self::assertEquals(new StyleFrame("\e[38;2;0;212;255m%s\e[39m", 0), $entries[190]);
        self::assertEquals(new StyleFrame("\e[38;2;0;208;255m%s\e[39m", 0), $entries[191]);
        self::assertEquals(new StyleFrame("\e[38;2;0;203;255m%s\e[39m", 0), $entries[192]);
        self::assertEquals(new StyleFrame("\e[38;2;0;199;255m%s\e[39m", 0), $entries[193]);
        self::assertEquals(new StyleFrame("\e[38;2;0;195;255m%s\e[39m", 0), $entries[194]);
        self::assertEquals(new StyleFrame("\e[38;2;0;191;255m%s\e[39m", 0), $entries[195]);
        self::assertEquals(new StyleFrame("\e[38;2;0;187;255m%s\e[39m", 0), $entries[196]);
        self::assertEquals(new StyleFrame("\e[38;2;0;182;255m%s\e[39m", 0), $entries[197]);
        self::assertEquals(new StyleFrame("\e[38;2;0;178;255m%s\e[39m", 0), $entries[198]);
        self::assertEquals(new StyleFrame("\e[38;2;0;174;255m%s\e[39m", 0), $entries[199]);
        self::assertEquals(new StyleFrame("\e[38;2;0;169;255m%s\e[39m", 0), $entries[200]);
        self::assertEquals(new StyleFrame("\e[38;2;0;165;255m%s\e[39m", 0), $entries[201]);
        self::assertEquals(new StyleFrame("\e[38;2;0;161;255m%s\e[39m", 0), $entries[202]);
        self::assertEquals(new StyleFrame("\e[38;2;0;157;255m%s\e[39m", 0), $entries[203]);
        self::assertEquals(new StyleFrame("\e[38;2;0;153;255m%s\e[39m", 0), $entries[204]);
        self::assertEquals(new StyleFrame("\e[38;2;0;148;255m%s\e[39m", 0), $entries[205]);
        self::assertEquals(new StyleFrame("\e[38;2;0;144;255m%s\e[39m", 0), $entries[206]);
        self::assertEquals(new StyleFrame("\e[38;2;0;140;255m%s\e[39m", 0), $entries[207]);
        self::assertEquals(new StyleFrame("\e[38;2;0;136;255m%s\e[39m", 0), $entries[208]);
        self::assertEquals(new StyleFrame("\e[38;2;0;131;255m%s\e[39m", 0), $entries[209]);
        self::assertEquals(new StyleFrame("\e[38;2;0;127;255m%s\e[39m", 0), $entries[210]);
        self::assertEquals(new StyleFrame("\e[38;2;0;123;255m%s\e[39m", 0), $entries[211]);
        self::assertEquals(new StyleFrame("\e[38;2;0;119;255m%s\e[39m", 0), $entries[212]);
        self::assertEquals(new StyleFrame("\e[38;2;0;114;255m%s\e[39m", 0), $entries[213]);
        self::assertEquals(new StyleFrame("\e[38;2;0;110;255m%s\e[39m", 0), $entries[214]);
        self::assertEquals(new StyleFrame("\e[38;2;0;106;255m%s\e[39m", 0), $entries[215]);
        self::assertEquals(new StyleFrame("\e[38;2;0;102;255m%s\e[39m", 0), $entries[216]);
        self::assertEquals(new StyleFrame("\e[38;2;0;97;255m%s\e[39m", 0), $entries[217]);
        self::assertEquals(new StyleFrame("\e[38;2;0;93;255m%s\e[39m", 0), $entries[218]);
        self::assertEquals(new StyleFrame("\e[38;2;0;89;255m%s\e[39m", 0), $entries[219]);
        self::assertEquals(new StyleFrame("\e[38;2;0;84;255m%s\e[39m", 0), $entries[220]);
        self::assertEquals(new StyleFrame("\e[38;2;0;80;255m%s\e[39m", 0), $entries[221]);
        self::assertEquals(new StyleFrame("\e[38;2;0;76;255m%s\e[39m", 0), $entries[222]);
        self::assertEquals(new StyleFrame("\e[38;2;0;72;255m%s\e[39m", 0), $entries[223]);
        self::assertEquals(new StyleFrame("\e[38;2;0;67;255m%s\e[39m", 0), $entries[224]);
        self::assertEquals(new StyleFrame("\e[38;2;0;63;255m%s\e[39m", 0), $entries[225]);
        self::assertEquals(new StyleFrame("\e[38;2;0;59;255m%s\e[39m", 0), $entries[226]);
        self::assertEquals(new StyleFrame("\e[38;2;0;55;255m%s\e[39m", 0), $entries[227]);
        self::assertEquals(new StyleFrame("\e[38;2;0;51;255m%s\e[39m", 0), $entries[228]);
        self::assertEquals(new StyleFrame("\e[38;2;0;46;255m%s\e[39m", 0), $entries[229]);
        self::assertEquals(new StyleFrame("\e[38;2;0;42;255m%s\e[39m", 0), $entries[230]);
        self::assertEquals(new StyleFrame("\e[38;2;0;38;255m%s\e[39m", 0), $entries[231]);
        self::assertEquals(new StyleFrame("\e[38;2;0;33;255m%s\e[39m", 0), $entries[232]);
        self::assertEquals(new StyleFrame("\e[38;2;0;29;255m%s\e[39m", 0), $entries[233]);
        self::assertEquals(new StyleFrame("\e[38;2;0;25;255m%s\e[39m", 0), $entries[234]);
        self::assertEquals(new StyleFrame("\e[38;2;0;21;255m%s\e[39m", 0), $entries[235]);
        self::assertEquals(new StyleFrame("\e[38;2;0;16;255m%s\e[39m", 0), $entries[236]);
        self::assertEquals(new StyleFrame("\e[38;2;0;12;255m%s\e[39m", 0), $entries[237]);
        self::assertEquals(new StyleFrame("\e[38;2;0;8;255m%s\e[39m", 0), $entries[238]);
        self::assertEquals(new StyleFrame("\e[38;2;0;4;255m%s\e[39m", 0), $entries[239]);
        self::assertEquals(new StyleFrame("\e[38;2;0;0;255m%s\e[39m", 0), $entries[240]);
        self::assertEquals(new StyleFrame("\e[38;2;4;0;255m%s\e[39m", 0), $entries[241]);
        self::assertEquals(new StyleFrame("\e[38;2;8;0;255m%s\e[39m", 0), $entries[242]);
        self::assertEquals(new StyleFrame("\e[38;2;12;0;255m%s\e[39m", 0), $entries[243]);
        self::assertEquals(new StyleFrame("\e[38;2;16;0;255m%s\e[39m", 0), $entries[244]);
        self::assertEquals(new StyleFrame("\e[38;2;21;0;255m%s\e[39m", 0), $entries[245]);
        self::assertEquals(new StyleFrame("\e[38;2;25;0;255m%s\e[39m", 0), $entries[246]);
        self::assertEquals(new StyleFrame("\e[38;2;29;0;255m%s\e[39m", 0), $entries[247]);
        self::assertEquals(new StyleFrame("\e[38;2;33;0;255m%s\e[39m", 0), $entries[248]);
        self::assertEquals(new StyleFrame("\e[38;2;38;0;255m%s\e[39m", 0), $entries[249]);
        self::assertEquals(new StyleFrame("\e[38;2;42;0;255m%s\e[39m", 0), $entries[250]);
        self::assertEquals(new StyleFrame("\e[38;2;46;0;255m%s\e[39m", 0), $entries[251]);
        self::assertEquals(new StyleFrame("\e[38;2;50;0;255m%s\e[39m", 0), $entries[252]);
        self::assertEquals(new StyleFrame("\e[38;2;55;0;255m%s\e[39m", 0), $entries[253]);
        self::assertEquals(new StyleFrame("\e[38;2;59;0;255m%s\e[39m", 0), $entries[254]);
        self::assertEquals(new StyleFrame("\e[38;2;63;0;255m%s\e[39m", 0), $entries[255]);
        self::assertEquals(new StyleFrame("\e[38;2;67;0;255m%s\e[39m", 0), $entries[256]);
        self::assertEquals(new StyleFrame("\e[38;2;72;0;255m%s\e[39m", 0), $entries[257]);
        self::assertEquals(new StyleFrame("\e[38;2;76;0;255m%s\e[39m", 0), $entries[258]);
        self::assertEquals(new StyleFrame("\e[38;2;80;0;255m%s\e[39m", 0), $entries[259]);
        self::assertEquals(new StyleFrame("\e[38;2;84;0;255m%s\e[39m", 0), $entries[260]);
        self::assertEquals(new StyleFrame("\e[38;2;89;0;255m%s\e[39m", 0), $entries[261]);
        self::assertEquals(new StyleFrame("\e[38;2;93;0;255m%s\e[39m", 0), $entries[262]);
        self::assertEquals(new StyleFrame("\e[38;2;97;0;255m%s\e[39m", 0), $entries[263]);
        self::assertEquals(new StyleFrame("\e[38;2;101;0;255m%s\e[39m", 0), $entries[264]);
        self::assertEquals(new StyleFrame("\e[38;2;106;0;255m%s\e[39m", 0), $entries[265]);
        self::assertEquals(new StyleFrame("\e[38;2;110;0;255m%s\e[39m", 0), $entries[266]);
        self::assertEquals(new StyleFrame("\e[38;2;114;0;255m%s\e[39m", 0), $entries[267]);
        self::assertEquals(new StyleFrame("\e[38;2;119;0;255m%s\e[39m", 0), $entries[268]);
        self::assertEquals(new StyleFrame("\e[38;2;123;0;255m%s\e[39m", 0), $entries[269]);
        self::assertEquals(new StyleFrame("\e[38;2;127;0;255m%s\e[39m", 0), $entries[270]);
        self::assertEquals(new StyleFrame("\e[38;2;131;0;255m%s\e[39m", 0), $entries[271]);
        self::assertEquals(new StyleFrame("\e[38;2;135;0;255m%s\e[39m", 0), $entries[272]);
        self::assertEquals(new StyleFrame("\e[38;2;140;0;255m%s\e[39m", 0), $entries[273]);
        self::assertEquals(new StyleFrame("\e[38;2;144;0;255m%s\e[39m", 0), $entries[274]);
        self::assertEquals(new StyleFrame("\e[38;2;148;0;255m%s\e[39m", 0), $entries[275]);
        self::assertEquals(new StyleFrame("\e[38;2;153;0;255m%s\e[39m", 0), $entries[276]);
        self::assertEquals(new StyleFrame("\e[38;2;157;0;255m%s\e[39m", 0), $entries[277]);
        self::assertEquals(new StyleFrame("\e[38;2;161;0;255m%s\e[39m", 0), $entries[278]);
        self::assertEquals(new StyleFrame("\e[38;2;165;0;255m%s\e[39m", 0), $entries[279]);
        self::assertEquals(new StyleFrame("\e[38;2;170;0;255m%s\e[39m", 0), $entries[280]);
        self::assertEquals(new StyleFrame("\e[38;2;174;0;255m%s\e[39m", 0), $entries[281]);
        self::assertEquals(new StyleFrame("\e[38;2;178;0;255m%s\e[39m", 0), $entries[282]);
        self::assertEquals(new StyleFrame("\e[38;2;182;0;255m%s\e[39m", 0), $entries[283]);
        self::assertEquals(new StyleFrame("\e[38;2;187;0;255m%s\e[39m", 0), $entries[284]);
        self::assertEquals(new StyleFrame("\e[38;2;191;0;255m%s\e[39m", 0), $entries[285]);
        self::assertEquals(new StyleFrame("\e[38;2;195;0;255m%s\e[39m", 0), $entries[286]);
        self::assertEquals(new StyleFrame("\e[38;2;199;0;255m%s\e[39m", 0), $entries[287]);
        self::assertEquals(new StyleFrame("\e[38;2;204;0;255m%s\e[39m", 0), $entries[288]);
        self::assertEquals(new StyleFrame("\e[38;2;208;0;255m%s\e[39m", 0), $entries[289]);
        self::assertEquals(new StyleFrame("\e[38;2;212;0;255m%s\e[39m", 0), $entries[290]);
        self::assertEquals(new StyleFrame("\e[38;2;216;0;255m%s\e[39m", 0), $entries[291]);
        self::assertEquals(new StyleFrame("\e[38;2;221;0;255m%s\e[39m", 0), $entries[292]);
        self::assertEquals(new StyleFrame("\e[38;2;225;0;255m%s\e[39m", 0), $entries[293]);
        self::assertEquals(new StyleFrame("\e[38;2;229;0;255m%s\e[39m", 0), $entries[294]);
        self::assertEquals(new StyleFrame("\e[38;2;233;0;255m%s\e[39m", 0), $entries[295]);
        self::assertEquals(new StyleFrame("\e[38;2;238;0;255m%s\e[39m", 0), $entries[296]);
        self::assertEquals(new StyleFrame("\e[38;2;242;0;255m%s\e[39m", 0), $entries[297]);
        self::assertEquals(new StyleFrame("\e[38;2;246;0;255m%s\e[39m", 0), $entries[298]);
        self::assertEquals(new StyleFrame("\e[38;2;250;0;255m%s\e[39m", 0), $entries[299]);
        self::assertEquals(new StyleFrame("\e[38;2;255;0;255m%s\e[39m", 0), $entries[300]);
        self::assertEquals(new StyleFrame("\e[38;2;255;0;250m%s\e[39m", 0), $entries[301]);
        self::assertEquals(new StyleFrame("\e[38;2;255;0;246m%s\e[39m", 0), $entries[302]);
        self::assertEquals(new StyleFrame("\e[38;2;255;0;242m%s\e[39m", 0), $entries[303]);
        self::assertEquals(new StyleFrame("\e[38;2;255;0;238m%s\e[39m", 0), $entries[304]);
        self::assertEquals(new StyleFrame("\e[38;2;255;0;233m%s\e[39m", 0), $entries[305]);
        self::assertEquals(new StyleFrame("\e[38;2;255;0;229m%s\e[39m", 0), $entries[306]);
        self::assertEquals(new StyleFrame("\e[38;2;255;0;225m%s\e[39m", 0), $entries[307]);
        self::assertEquals(new StyleFrame("\e[38;2;255;0;221m%s\e[39m", 0), $entries[308]);
        self::assertEquals(new StyleFrame("\e[38;2;255;0;216m%s\e[39m", 0), $entries[309]);
        self::assertEquals(new StyleFrame("\e[38;2;255;0;212m%s\e[39m", 0), $entries[310]);
        self::assertEquals(new StyleFrame("\e[38;2;255;0;208m%s\e[39m", 0), $entries[311]);
        self::assertEquals(new StyleFrame("\e[38;2;255;0;203m%s\e[39m", 0), $entries[312]);
        self::assertEquals(new StyleFrame("\e[38;2;255;0;199m%s\e[39m", 0), $entries[313]);
        self::assertEquals(new StyleFrame("\e[38;2;255;0;195m%s\e[39m", 0), $entries[314]);
        self::assertEquals(new StyleFrame("\e[38;2;255;0;191m%s\e[39m", 0), $entries[315]);
        self::assertEquals(new StyleFrame("\e[38;2;255;0;187m%s\e[39m", 0), $entries[316]);
        self::assertEquals(new StyleFrame("\e[38;2;255;0;182m%s\e[39m", 0), $entries[317]);
        self::assertEquals(new StyleFrame("\e[38;2;255;0;178m%s\e[39m", 0), $entries[318]);
        self::assertEquals(new StyleFrame("\e[38;2;255;0;174m%s\e[39m", 0), $entries[319]);
        self::assertEquals(new StyleFrame("\e[38;2;255;0;170m%s\e[39m", 0), $entries[320]);
        self::assertEquals(new StyleFrame("\e[38;2;255;0;165m%s\e[39m", 0), $entries[321]);
        self::assertEquals(new StyleFrame("\e[38;2;255;0;161m%s\e[39m", 0), $entries[322]);
        self::assertEquals(new StyleFrame("\e[38;2;255;0;157m%s\e[39m", 0), $entries[323]);
        self::assertEquals(new StyleFrame("\e[38;2;255;0;152m%s\e[39m", 0), $entries[324]);
        self::assertEquals(new StyleFrame("\e[38;2;255;0;148m%s\e[39m", 0), $entries[325]);
        self::assertEquals(new StyleFrame("\e[38;2;255;0;144m%s\e[39m", 0), $entries[326]);
        self::assertEquals(new StyleFrame("\e[38;2;255;0;140m%s\e[39m", 0), $entries[327]);
        self::assertEquals(new StyleFrame("\e[38;2;255;0;135m%s\e[39m", 0), $entries[328]);
        self::assertEquals(new StyleFrame("\e[38;2;255;0;131m%s\e[39m", 0), $entries[329]);
        self::assertEquals(new StyleFrame("\e[38;2;255;0;127m%s\e[39m", 0), $entries[330]);
        self::assertEquals(new StyleFrame("\e[38;2;255;0;123m%s\e[39m", 0), $entries[331]);
        self::assertEquals(new StyleFrame("\e[38;2;255;0;119m%s\e[39m", 0), $entries[332]);
        self::assertEquals(new StyleFrame("\e[38;2;255;0;114m%s\e[39m", 0), $entries[333]);
        self::assertEquals(new StyleFrame("\e[38;2;255;0;110m%s\e[39m", 0), $entries[334]);
        self::assertEquals(new StyleFrame("\e[38;2;255;0;106m%s\e[39m", 0), $entries[335]);
        self::assertEquals(new StyleFrame("\e[38;2;255;0;102m%s\e[39m", 0), $entries[336]);
        self::assertEquals(new StyleFrame("\e[38;2;255;0;97m%s\e[39m", 0), $entries[337]);
        self::assertEquals(new StyleFrame("\e[38;2;255;0;93m%s\e[39m", 0), $entries[338]);
        self::assertEquals(new StyleFrame("\e[38;2;255;0;89m%s\e[39m", 0), $entries[339]);
        self::assertEquals(new StyleFrame("\e[38;2;255;0;85m%s\e[39m", 0), $entries[340]);
        self::assertEquals(new StyleFrame("\e[38;2;255;0;80m%s\e[39m", 0), $entries[341]);
        self::assertEquals(new StyleFrame("\e[38;2;255;0;76m%s\e[39m", 0), $entries[342]);
        self::assertEquals(new StyleFrame("\e[38;2;255;0;72m%s\e[39m", 0), $entries[343]);
        self::assertEquals(new StyleFrame("\e[38;2;255;0;67m%s\e[39m", 0), $entries[344]);
        self::assertEquals(new StyleFrame("\e[38;2;255;0;63m%s\e[39m", 0), $entries[345]);
        self::assertEquals(new StyleFrame("\e[38;2;255;0;59m%s\e[39m", 0), $entries[346]);
        self::assertEquals(new StyleFrame("\e[38;2;255;0;55m%s\e[39m", 0), $entries[347]);
        self::assertEquals(new StyleFrame("\e[38;2;255;0;51m%s\e[39m", 0), $entries[348]);
        self::assertEquals(new StyleFrame("\e[38;2;255;0;46m%s\e[39m", 0), $entries[349]);
        self::assertEquals(new StyleFrame("\e[38;2;255;0;42m%s\e[39m", 0), $entries[350]);
        self::assertEquals(new StyleFrame("\e[38;2;255;0;38m%s\e[39m", 0), $entries[351]);
        self::assertEquals(new StyleFrame("\e[38;2;255;0;34m%s\e[39m", 0), $entries[352]);
        self::assertEquals(new StyleFrame("\e[38;2;255;0;29m%s\e[39m", 0), $entries[353]);
        self::assertEquals(new StyleFrame("\e[38;2;255;0;25m%s\e[39m", 0), $entries[354]);
        self::assertEquals(new StyleFrame("\e[38;2;255;0;21m%s\e[39m", 0), $entries[355]);
        self::assertEquals(new StyleFrame("\e[38;2;255;0;16m%s\e[39m", 0), $entries[356]);
        self::assertEquals(new StyleFrame("\e[38;2;255;0;12m%s\e[39m", 0), $entries[357]);
        self::assertEquals(new StyleFrame("\e[38;2;255;0;8m%s\e[39m", 0), $entries[358]);
        self::assertEquals(new StyleFrame("\e[38;2;255;0;4m%s\e[39m", 0), $entries[359]);
    }

    #[Test]
    public function returnsFramesOnStylingModeANSI24AndCustomOptions(): void
    {
        $interval = 90;
        $options = $this->getPaletteOptionsMock();
        $options
            ->expects(self::once())
            ->method('getInterval')
            ->willReturn($interval)
        ;
        $options
            ->expects(self::once())
            ->method('getReversed')
            ->willReturn(true)
        ;

        $palette = $this->getTesteeInstance(
            options: $options
        );

        $mode = $this->getPaletteModeMock();
        $mode
            ->expects(self::once())
            ->method('getStylingMode')
            ->willReturn(StylingMethodMode::ANSI24)
        ;

        $traversable = $palette->getEntries($mode);

        self::assertInstanceOf(\Generator::class, $traversable);

        $entries = iterator_to_array($traversable); // unwrap generator

        self::assertCount(360, $entries);

        self::assertSame($interval, $palette->getOptions()->getInterval());
        self::assertTrue($palette->getOptions()->getReversed());

        self::assertEquals(new StyleFrame("\e[38;2;255;0;0m%s\e[39m", 0), $entries[359]);
        self::assertEquals(new StyleFrame("\e[38;2;255;4;0m%s\e[39m", 0), $entries[358]);
        self::assertEquals(new StyleFrame("\e[38;2;255;8;0m%s\e[39m", 0), $entries[357]);
        self::assertEquals(new StyleFrame("\e[38;2;255;12;0m%s\e[39m", 0), $entries[356]);
        self::assertEquals(new StyleFrame("\e[38;2;255;16;0m%s\e[39m", 0), $entries[355]);
        self::assertEquals(new StyleFrame("\e[38;2;255;21;0m%s\e[39m", 0), $entries[354]);
        self::assertEquals(new StyleFrame("\e[38;2;255;25;0m%s\e[39m", 0), $entries[353]);
        self::assertEquals(new StyleFrame("\e[38;2;255;29;0m%s\e[39m", 0), $entries[352]);
        self::assertEquals(new StyleFrame("\e[38;2;255;33;0m%s\e[39m", 0), $entries[351]);
        self::assertEquals(new StyleFrame("\e[38;2;255;38;0m%s\e[39m", 0), $entries[350]);
        self::assertEquals(new StyleFrame("\e[38;2;255;42;0m%s\e[39m", 0), $entries[349]);
        self::assertEquals(new StyleFrame("\e[38;2;255;46;0m%s\e[39m", 0), $entries[348]);
        self::assertEquals(new StyleFrame("\e[38;2;255;50;0m%s\e[39m", 0), $entries[347]);
        self::assertEquals(new StyleFrame("\e[38;2;255;55;0m%s\e[39m", 0), $entries[346]);
        self::assertEquals(new StyleFrame("\e[38;2;255;59;0m%s\e[39m", 0), $entries[345]);
        self::assertEquals(new StyleFrame("\e[38;2;255;63;0m%s\e[39m", 0), $entries[344]);
        self::assertEquals(new StyleFrame("\e[38;2;255;67;0m%s\e[39m", 0), $entries[343]);
        self::assertEquals(new StyleFrame("\e[38;2;255;72;0m%s\e[39m", 0), $entries[342]);
        self::assertEquals(new StyleFrame("\e[38;2;255;76;0m%s\e[39m", 0), $entries[341]);
        self::assertEquals(new StyleFrame("\e[38;2;255;80;0m%s\e[39m", 0), $entries[340]);
        self::assertEquals(new StyleFrame("\e[38;2;255;84;0m%s\e[39m", 0), $entries[339]);
        self::assertEquals(new StyleFrame("\e[38;2;255;89;0m%s\e[39m", 0), $entries[338]);
        self::assertEquals(new StyleFrame("\e[38;2;255;93;0m%s\e[39m", 0), $entries[337]);
        self::assertEquals(new StyleFrame("\e[38;2;255;97;0m%s\e[39m", 0), $entries[336]);
        self::assertEquals(new StyleFrame("\e[38;2;255;102;0m%s\e[39m", 0), $entries[335]);
        self::assertEquals(new StyleFrame("\e[38;2;255;106;0m%s\e[39m", 0), $entries[334]);
        self::assertEquals(new StyleFrame("\e[38;2;255;110;0m%s\e[39m", 0), $entries[333]);
        self::assertEquals(new StyleFrame("\e[38;2;255;114;0m%s\e[39m", 0), $entries[332]);
        self::assertEquals(new StyleFrame("\e[38;2;255;119;0m%s\e[39m", 0), $entries[331]);
        self::assertEquals(new StyleFrame("\e[38;2;255;123;0m%s\e[39m", 0), $entries[330]);
        self::assertEquals(new StyleFrame("\e[38;2;255;127;0m%s\e[39m", 0), $entries[329]);
        self::assertEquals(new StyleFrame("\e[38;2;255;131;0m%s\e[39m", 0), $entries[328]);
        self::assertEquals(new StyleFrame("\e[38;2;255;136;0m%s\e[39m", 0), $entries[327]);
        self::assertEquals(new StyleFrame("\e[38;2;255;140;0m%s\e[39m", 0), $entries[326]);
        self::assertEquals(new StyleFrame("\e[38;2;255;144;0m%s\e[39m", 0), $entries[325]);
        self::assertEquals(new StyleFrame("\e[38;2;255;148;0m%s\e[39m", 0), $entries[324]);
        self::assertEquals(new StyleFrame("\e[38;2;255;153;0m%s\e[39m", 0), $entries[323]);
        self::assertEquals(new StyleFrame("\e[38;2;255;157;0m%s\e[39m", 0), $entries[322]);
        self::assertEquals(new StyleFrame("\e[38;2;255;161;0m%s\e[39m", 0), $entries[321]);
        self::assertEquals(new StyleFrame("\e[38;2;255;165;0m%s\e[39m", 0), $entries[320]);
        self::assertEquals(new StyleFrame("\e[38;2;255;170;0m%s\e[39m", 0), $entries[319]);
        self::assertEquals(new StyleFrame("\e[38;2;255;174;0m%s\e[39m", 0), $entries[318]);
        self::assertEquals(new StyleFrame("\e[38;2;255;178;0m%s\e[39m", 0), $entries[317]);
        self::assertEquals(new StyleFrame("\e[38;2;255;182;0m%s\e[39m", 0), $entries[316]);
        self::assertEquals(new StyleFrame("\e[38;2;255;187;0m%s\e[39m", 0), $entries[315]);
        self::assertEquals(new StyleFrame("\e[38;2;255;191;0m%s\e[39m", 0), $entries[314]);
        self::assertEquals(new StyleFrame("\e[38;2;255;195;0m%s\e[39m", 0), $entries[313]);
        self::assertEquals(new StyleFrame("\e[38;2;255;199;0m%s\e[39m", 0), $entries[312]);
        self::assertEquals(new StyleFrame("\e[38;2;255;204;0m%s\e[39m", 0), $entries[311]);
        self::assertEquals(new StyleFrame("\e[38;2;255;208;0m%s\e[39m", 0), $entries[310]);
        self::assertEquals(new StyleFrame("\e[38;2;255;212;0m%s\e[39m", 0), $entries[309]);
        self::assertEquals(new StyleFrame("\e[38;2;255;216;0m%s\e[39m", 0), $entries[308]);
        self::assertEquals(new StyleFrame("\e[38;2;255;220;0m%s\e[39m", 0), $entries[307]);
        self::assertEquals(new StyleFrame("\e[38;2;255;225;0m%s\e[39m", 0), $entries[306]);
        self::assertEquals(new StyleFrame("\e[38;2;255;229;0m%s\e[39m", 0), $entries[305]);
        self::assertEquals(new StyleFrame("\e[38;2;255;233;0m%s\e[39m", 0), $entries[304]);
        self::assertEquals(new StyleFrame("\e[38;2;255;238;0m%s\e[39m", 0), $entries[303]);
        self::assertEquals(new StyleFrame("\e[38;2;255;242;0m%s\e[39m", 0), $entries[302]);
        self::assertEquals(new StyleFrame("\e[38;2;255;246;0m%s\e[39m", 0), $entries[301]);
        self::assertEquals(new StyleFrame("\e[38;2;255;250;0m%s\e[39m", 0), $entries[300]);
        self::assertEquals(new StyleFrame("\e[38;2;255;255;0m%s\e[39m", 0), $entries[299]);
        self::assertEquals(new StyleFrame("\e[38;2;250;255;0m%s\e[39m", 0), $entries[298]);
        self::assertEquals(new StyleFrame("\e[38;2;246;255;0m%s\e[39m", 0), $entries[297]);
        self::assertEquals(new StyleFrame("\e[38;2;242;255;0m%s\e[39m", 0), $entries[296]);
        self::assertEquals(new StyleFrame("\e[38;2;238;255;0m%s\e[39m", 0), $entries[295]);
        self::assertEquals(new StyleFrame("\e[38;2;233;255;0m%s\e[39m", 0), $entries[294]);
        self::assertEquals(new StyleFrame("\e[38;2;229;255;0m%s\e[39m", 0), $entries[293]);
        self::assertEquals(new StyleFrame("\e[38;2;225;255;0m%s\e[39m", 0), $entries[292]);
        self::assertEquals(new StyleFrame("\e[38;2;221;255;0m%s\e[39m", 0), $entries[291]);
        self::assertEquals(new StyleFrame("\e[38;2;216;255;0m%s\e[39m", 0), $entries[290]);
        self::assertEquals(new StyleFrame("\e[38;2;212;255;0m%s\e[39m", 0), $entries[289]);
        self::assertEquals(new StyleFrame("\e[38;2;208;255;0m%s\e[39m", 0), $entries[288]);
        self::assertEquals(new StyleFrame("\e[38;2;203;255;0m%s\e[39m", 0), $entries[287]);
        self::assertEquals(new StyleFrame("\e[38;2;199;255;0m%s\e[39m", 0), $entries[286]);
        self::assertEquals(new StyleFrame("\e[38;2;195;255;0m%s\e[39m", 0), $entries[285]);
        self::assertEquals(new StyleFrame("\e[38;2;191;255;0m%s\e[39m", 0), $entries[284]);
        self::assertEquals(new StyleFrame("\e[38;2;187;255;0m%s\e[39m", 0), $entries[283]);
        self::assertEquals(new StyleFrame("\e[38;2;182;255;0m%s\e[39m", 0), $entries[282]);
        self::assertEquals(new StyleFrame("\e[38;2;178;255;0m%s\e[39m", 0), $entries[281]);
        self::assertEquals(new StyleFrame("\e[38;2;174;255;0m%s\e[39m", 0), $entries[280]);
        self::assertEquals(new StyleFrame("\e[38;2;170;255;0m%s\e[39m", 0), $entries[279]);
        self::assertEquals(new StyleFrame("\e[38;2;165;255;0m%s\e[39m", 0), $entries[278]);
        self::assertEquals(new StyleFrame("\e[38;2;161;255;0m%s\e[39m", 0), $entries[277]);
        self::assertEquals(new StyleFrame("\e[38;2;157;255;0m%s\e[39m", 0), $entries[276]);
        self::assertEquals(new StyleFrame("\e[38;2;153;255;0m%s\e[39m", 0), $entries[275]);
        self::assertEquals(new StyleFrame("\e[38;2;148;255;0m%s\e[39m", 0), $entries[274]);
        self::assertEquals(new StyleFrame("\e[38;2;144;255;0m%s\e[39m", 0), $entries[273]);
        self::assertEquals(new StyleFrame("\e[38;2;140;255;0m%s\e[39m", 0), $entries[272]);
        self::assertEquals(new StyleFrame("\e[38;2;136;255;0m%s\e[39m", 0), $entries[271]);
        self::assertEquals(new StyleFrame("\e[38;2;131;255;0m%s\e[39m", 0), $entries[270]);
        self::assertEquals(new StyleFrame("\e[38;2;127;255;0m%s\e[39m", 0), $entries[269]);
        self::assertEquals(new StyleFrame("\e[38;2;123;255;0m%s\e[39m", 0), $entries[268]);
        self::assertEquals(new StyleFrame("\e[38;2;119;255;0m%s\e[39m", 0), $entries[267]);
        self::assertEquals(new StyleFrame("\e[38;2;114;255;0m%s\e[39m", 0), $entries[266]);
        self::assertEquals(new StyleFrame("\e[38;2;110;255;0m%s\e[39m", 0), $entries[265]);
        self::assertEquals(new StyleFrame("\e[38;2;106;255;0m%s\e[39m", 0), $entries[264]);
        self::assertEquals(new StyleFrame("\e[38;2;101;255;0m%s\e[39m", 0), $entries[263]);
        self::assertEquals(new StyleFrame("\e[38;2;97;255;0m%s\e[39m", 0), $entries[262]);
        self::assertEquals(new StyleFrame("\e[38;2;93;255;0m%s\e[39m", 0), $entries[261]);
        self::assertEquals(new StyleFrame("\e[38;2;89;255;0m%s\e[39m", 0), $entries[260]);
        self::assertEquals(new StyleFrame("\e[38;2;84;255;0m%s\e[39m", 0), $entries[259]);
        self::assertEquals(new StyleFrame("\e[38;2;80;255;0m%s\e[39m", 0), $entries[258]);
        self::assertEquals(new StyleFrame("\e[38;2;76;255;0m%s\e[39m", 0), $entries[257]);
        self::assertEquals(new StyleFrame("\e[38;2;72;255;0m%s\e[39m", 0), $entries[256]);
        self::assertEquals(new StyleFrame("\e[38;2;68;255;0m%s\e[39m", 0), $entries[255]);
        self::assertEquals(new StyleFrame("\e[38;2;63;255;0m%s\e[39m", 0), $entries[254]);
        self::assertEquals(new StyleFrame("\e[38;2;59;255;0m%s\e[39m", 0), $entries[253]);
        self::assertEquals(new StyleFrame("\e[38;2;55;255;0m%s\e[39m", 0), $entries[252]);
        self::assertEquals(new StyleFrame("\e[38;2;51;255;0m%s\e[39m", 0), $entries[251]);
        self::assertEquals(new StyleFrame("\e[38;2;46;255;0m%s\e[39m", 0), $entries[250]);
        self::assertEquals(new StyleFrame("\e[38;2;42;255;0m%s\e[39m", 0), $entries[249]);
        self::assertEquals(new StyleFrame("\e[38;2;38;255;0m%s\e[39m", 0), $entries[248]);
        self::assertEquals(new StyleFrame("\e[38;2;33;255;0m%s\e[39m", 0), $entries[247]);
        self::assertEquals(new StyleFrame("\e[38;2;29;255;0m%s\e[39m", 0), $entries[246]);
        self::assertEquals(new StyleFrame("\e[38;2;25;255;0m%s\e[39m", 0), $entries[245]);
        self::assertEquals(new StyleFrame("\e[38;2;21;255;0m%s\e[39m", 0), $entries[244]);
        self::assertEquals(new StyleFrame("\e[38;2;16;255;0m%s\e[39m", 0), $entries[243]);
        self::assertEquals(new StyleFrame("\e[38;2;12;255;0m%s\e[39m", 0), $entries[242]);
        self::assertEquals(new StyleFrame("\e[38;2;8;255;0m%s\e[39m", 0), $entries[241]);
        self::assertEquals(new StyleFrame("\e[38;2;4;255;0m%s\e[39m", 0), $entries[240]);
        self::assertEquals(new StyleFrame("\e[38;2;0;255;0m%s\e[39m", 0), $entries[239]);
        self::assertEquals(new StyleFrame("\e[38;2;0;255;4m%s\e[39m", 0), $entries[238]);
        self::assertEquals(new StyleFrame("\e[38;2;0;255;8m%s\e[39m", 0), $entries[237]);
        self::assertEquals(new StyleFrame("\e[38;2;0;255;12m%s\e[39m", 0), $entries[236]);
        self::assertEquals(new StyleFrame("\e[38;2;0;255;16m%s\e[39m", 0), $entries[235]);
        self::assertEquals(new StyleFrame("\e[38;2;0;255;21m%s\e[39m", 0), $entries[234]);
        self::assertEquals(new StyleFrame("\e[38;2;0;255;25m%s\e[39m", 0), $entries[233]);
        self::assertEquals(new StyleFrame("\e[38;2;0;255;29m%s\e[39m", 0), $entries[232]);
        self::assertEquals(new StyleFrame("\e[38;2;0;255;33m%s\e[39m", 0), $entries[231]);
        self::assertEquals(new StyleFrame("\e[38;2;0;255;38m%s\e[39m", 0), $entries[230]);
        self::assertEquals(new StyleFrame("\e[38;2;0;255;42m%s\e[39m", 0), $entries[229]);
        self::assertEquals(new StyleFrame("\e[38;2;0;255;46m%s\e[39m", 0), $entries[228]);
        self::assertEquals(new StyleFrame("\e[38;2;0;255;50m%s\e[39m", 0), $entries[227]);
        self::assertEquals(new StyleFrame("\e[38;2;0;255;55m%s\e[39m", 0), $entries[226]);
        self::assertEquals(new StyleFrame("\e[38;2;0;255;59m%s\e[39m", 0), $entries[225]);
        self::assertEquals(new StyleFrame("\e[38;2;0;255;63m%s\e[39m", 0), $entries[224]);
        self::assertEquals(new StyleFrame("\e[38;2;0;255;67m%s\e[39m", 0), $entries[223]);
        self::assertEquals(new StyleFrame("\e[38;2;0;255;72m%s\e[39m", 0), $entries[222]);
        self::assertEquals(new StyleFrame("\e[38;2;0;255;76m%s\e[39m", 0), $entries[221]);
        self::assertEquals(new StyleFrame("\e[38;2;0;255;80m%s\e[39m", 0), $entries[220]);
        self::assertEquals(new StyleFrame("\e[38;2;0;255;85m%s\e[39m", 0), $entries[219]);
        self::assertEquals(new StyleFrame("\e[38;2;0;255;89m%s\e[39m", 0), $entries[218]);
        self::assertEquals(new StyleFrame("\e[38;2;0;255;93m%s\e[39m", 0), $entries[217]);
        self::assertEquals(new StyleFrame("\e[38;2;0;255;97m%s\e[39m", 0), $entries[216]);
        self::assertEquals(new StyleFrame("\e[38;2;0;255;102m%s\e[39m", 0), $entries[215]);
        self::assertEquals(new StyleFrame("\e[38;2;0;255;106m%s\e[39m", 0), $entries[214]);
        self::assertEquals(new StyleFrame("\e[38;2;0;255;110m%s\e[39m", 0), $entries[213]);
        self::assertEquals(new StyleFrame("\e[38;2;0;255;114m%s\e[39m", 0), $entries[212]);
        self::assertEquals(new StyleFrame("\e[38;2;0;255;119m%s\e[39m", 0), $entries[211]);
        self::assertEquals(new StyleFrame("\e[38;2;0;255;123m%s\e[39m", 0), $entries[210]);
        self::assertEquals(new StyleFrame("\e[38;2;0;255;127m%s\e[39m", 0), $entries[209]);
        self::assertEquals(new StyleFrame("\e[38;2;0;255;131m%s\e[39m", 0), $entries[208]);
        self::assertEquals(new StyleFrame("\e[38;2;0;255;135m%s\e[39m", 0), $entries[207]);
        self::assertEquals(new StyleFrame("\e[38;2;0;255;140m%s\e[39m", 0), $entries[206]);
        self::assertEquals(new StyleFrame("\e[38;2;0;255;144m%s\e[39m", 0), $entries[205]);
        self::assertEquals(new StyleFrame("\e[38;2;0;255;148m%s\e[39m", 0), $entries[204]);
        self::assertEquals(new StyleFrame("\e[38;2;0;255;153m%s\e[39m", 0), $entries[203]);
        self::assertEquals(new StyleFrame("\e[38;2;0;255;157m%s\e[39m", 0), $entries[202]);
        self::assertEquals(new StyleFrame("\e[38;2;0;255;161m%s\e[39m", 0), $entries[201]);
        self::assertEquals(new StyleFrame("\e[38;2;0;255;165m%s\e[39m", 0), $entries[200]);
        self::assertEquals(new StyleFrame("\e[38;2;0;255;169m%s\e[39m", 0), $entries[199]);
        self::assertEquals(new StyleFrame("\e[38;2;0;255;174m%s\e[39m", 0), $entries[198]);
        self::assertEquals(new StyleFrame("\e[38;2;0;255;178m%s\e[39m", 0), $entries[197]);
        self::assertEquals(new StyleFrame("\e[38;2;0;255;182m%s\e[39m", 0), $entries[196]);
        self::assertEquals(new StyleFrame("\e[38;2;0;255;187m%s\e[39m", 0), $entries[195]);
        self::assertEquals(new StyleFrame("\e[38;2;0;255;191m%s\e[39m", 0), $entries[194]);
        self::assertEquals(new StyleFrame("\e[38;2;0;255;195m%s\e[39m", 0), $entries[193]);
        self::assertEquals(new StyleFrame("\e[38;2;0;255;199m%s\e[39m", 0), $entries[192]);
        self::assertEquals(new StyleFrame("\e[38;2;0;255;203m%s\e[39m", 0), $entries[191]);
        self::assertEquals(new StyleFrame("\e[38;2;0;255;208m%s\e[39m", 0), $entries[190]);
        self::assertEquals(new StyleFrame("\e[38;2;0;255;212m%s\e[39m", 0), $entries[189]);
        self::assertEquals(new StyleFrame("\e[38;2;0;255;216m%s\e[39m", 0), $entries[188]);
        self::assertEquals(new StyleFrame("\e[38;2;0;255;221m%s\e[39m", 0), $entries[187]);
        self::assertEquals(new StyleFrame("\e[38;2;0;255;225m%s\e[39m", 0), $entries[186]);
        self::assertEquals(new StyleFrame("\e[38;2;0;255;229m%s\e[39m", 0), $entries[185]);
        self::assertEquals(new StyleFrame("\e[38;2;0;255;233m%s\e[39m", 0), $entries[184]);
        self::assertEquals(new StyleFrame("\e[38;2;0;255;237m%s\e[39m", 0), $entries[183]);
        self::assertEquals(new StyleFrame("\e[38;2;0;255;242m%s\e[39m", 0), $entries[182]);
        self::assertEquals(new StyleFrame("\e[38;2;0;255;246m%s\e[39m", 0), $entries[181]);
        self::assertEquals(new StyleFrame("\e[38;2;0;255;250m%s\e[39m", 0), $entries[180]);
        self::assertEquals(new StyleFrame("\e[38;2;0;255;255m%s\e[39m", 0), $entries[179]);
        self::assertEquals(new StyleFrame("\e[38;2;0;250;255m%s\e[39m", 0), $entries[178]);
        self::assertEquals(new StyleFrame("\e[38;2;0;246;255m%s\e[39m", 0), $entries[177]);
        self::assertEquals(new StyleFrame("\e[38;2;0;242;255m%s\e[39m", 0), $entries[176]);
        self::assertEquals(new StyleFrame("\e[38;2;0;238;255m%s\e[39m", 0), $entries[175]);
        self::assertEquals(new StyleFrame("\e[38;2;0;233;255m%s\e[39m", 0), $entries[174]);
        self::assertEquals(new StyleFrame("\e[38;2;0;229;255m%s\e[39m", 0), $entries[173]);
        self::assertEquals(new StyleFrame("\e[38;2;0;225;255m%s\e[39m", 0), $entries[172]);
        self::assertEquals(new StyleFrame("\e[38;2;0;220;255m%s\e[39m", 0), $entries[171]);
        self::assertEquals(new StyleFrame("\e[38;2;0;216;255m%s\e[39m", 0), $entries[170]);
        self::assertEquals(new StyleFrame("\e[38;2;0;212;255m%s\e[39m", 0), $entries[169]);
        self::assertEquals(new StyleFrame("\e[38;2;0;208;255m%s\e[39m", 0), $entries[168]);
        self::assertEquals(new StyleFrame("\e[38;2;0;203;255m%s\e[39m", 0), $entries[167]);
        self::assertEquals(new StyleFrame("\e[38;2;0;199;255m%s\e[39m", 0), $entries[166]);
        self::assertEquals(new StyleFrame("\e[38;2;0;195;255m%s\e[39m", 0), $entries[165]);
        self::assertEquals(new StyleFrame("\e[38;2;0;191;255m%s\e[39m", 0), $entries[164]);
        self::assertEquals(new StyleFrame("\e[38;2;0;187;255m%s\e[39m", 0), $entries[163]);
        self::assertEquals(new StyleFrame("\e[38;2;0;182;255m%s\e[39m", 0), $entries[162]);
        self::assertEquals(new StyleFrame("\e[38;2;0;178;255m%s\e[39m", 0), $entries[161]);
        self::assertEquals(new StyleFrame("\e[38;2;0;174;255m%s\e[39m", 0), $entries[160]);
        self::assertEquals(new StyleFrame("\e[38;2;0;169;255m%s\e[39m", 0), $entries[159]);
        self::assertEquals(new StyleFrame("\e[38;2;0;165;255m%s\e[39m", 0), $entries[158]);
        self::assertEquals(new StyleFrame("\e[38;2;0;161;255m%s\e[39m", 0), $entries[157]);
        self::assertEquals(new StyleFrame("\e[38;2;0;157;255m%s\e[39m", 0), $entries[156]);
        self::assertEquals(new StyleFrame("\e[38;2;0;153;255m%s\e[39m", 0), $entries[155]);
        self::assertEquals(new StyleFrame("\e[38;2;0;148;255m%s\e[39m", 0), $entries[154]);
        self::assertEquals(new StyleFrame("\e[38;2;0;144;255m%s\e[39m", 0), $entries[153]);
        self::assertEquals(new StyleFrame("\e[38;2;0;140;255m%s\e[39m", 0), $entries[152]);
        self::assertEquals(new StyleFrame("\e[38;2;0;136;255m%s\e[39m", 0), $entries[151]);
        self::assertEquals(new StyleFrame("\e[38;2;0;131;255m%s\e[39m", 0), $entries[150]);
        self::assertEquals(new StyleFrame("\e[38;2;0;127;255m%s\e[39m", 0), $entries[149]);
        self::assertEquals(new StyleFrame("\e[38;2;0;123;255m%s\e[39m", 0), $entries[148]);
        self::assertEquals(new StyleFrame("\e[38;2;0;119;255m%s\e[39m", 0), $entries[147]);
        self::assertEquals(new StyleFrame("\e[38;2;0;114;255m%s\e[39m", 0), $entries[146]);
        self::assertEquals(new StyleFrame("\e[38;2;0;110;255m%s\e[39m", 0), $entries[145]);
        self::assertEquals(new StyleFrame("\e[38;2;0;106;255m%s\e[39m", 0), $entries[144]);
        self::assertEquals(new StyleFrame("\e[38;2;0;102;255m%s\e[39m", 0), $entries[143]);
        self::assertEquals(new StyleFrame("\e[38;2;0;97;255m%s\e[39m", 0), $entries[142]);
        self::assertEquals(new StyleFrame("\e[38;2;0;93;255m%s\e[39m", 0), $entries[141]);
        self::assertEquals(new StyleFrame("\e[38;2;0;89;255m%s\e[39m", 0), $entries[140]);
        self::assertEquals(new StyleFrame("\e[38;2;0;84;255m%s\e[39m", 0), $entries[139]);
        self::assertEquals(new StyleFrame("\e[38;2;0;80;255m%s\e[39m", 0), $entries[138]);
        self::assertEquals(new StyleFrame("\e[38;2;0;76;255m%s\e[39m", 0), $entries[137]);
        self::assertEquals(new StyleFrame("\e[38;2;0;72;255m%s\e[39m", 0), $entries[136]);
        self::assertEquals(new StyleFrame("\e[38;2;0;67;255m%s\e[39m", 0), $entries[135]);
        self::assertEquals(new StyleFrame("\e[38;2;0;63;255m%s\e[39m", 0), $entries[134]);
        self::assertEquals(new StyleFrame("\e[38;2;0;59;255m%s\e[39m", 0), $entries[133]);
        self::assertEquals(new StyleFrame("\e[38;2;0;55;255m%s\e[39m", 0), $entries[132]);
        self::assertEquals(new StyleFrame("\e[38;2;0;51;255m%s\e[39m", 0), $entries[131]);
        self::assertEquals(new StyleFrame("\e[38;2;0;46;255m%s\e[39m", 0), $entries[130]);
        self::assertEquals(new StyleFrame("\e[38;2;0;42;255m%s\e[39m", 0), $entries[129]);
        self::assertEquals(new StyleFrame("\e[38;2;0;38;255m%s\e[39m", 0), $entries[128]);
        self::assertEquals(new StyleFrame("\e[38;2;0;33;255m%s\e[39m", 0), $entries[127]);
        self::assertEquals(new StyleFrame("\e[38;2;0;29;255m%s\e[39m", 0), $entries[126]);
        self::assertEquals(new StyleFrame("\e[38;2;0;25;255m%s\e[39m", 0), $entries[125]);
        self::assertEquals(new StyleFrame("\e[38;2;0;21;255m%s\e[39m", 0), $entries[124]);
        self::assertEquals(new StyleFrame("\e[38;2;0;16;255m%s\e[39m", 0), $entries[123]);
        self::assertEquals(new StyleFrame("\e[38;2;0;12;255m%s\e[39m", 0), $entries[122]);
        self::assertEquals(new StyleFrame("\e[38;2;0;8;255m%s\e[39m", 0), $entries[121]);
        self::assertEquals(new StyleFrame("\e[38;2;0;4;255m%s\e[39m", 0), $entries[120]);
        self::assertEquals(new StyleFrame("\e[38;2;0;0;255m%s\e[39m", 0), $entries[119]);
        self::assertEquals(new StyleFrame("\e[38;2;4;0;255m%s\e[39m", 0), $entries[118]);
        self::assertEquals(new StyleFrame("\e[38;2;8;0;255m%s\e[39m", 0), $entries[117]);
        self::assertEquals(new StyleFrame("\e[38;2;12;0;255m%s\e[39m", 0), $entries[116]);
        self::assertEquals(new StyleFrame("\e[38;2;16;0;255m%s\e[39m", 0), $entries[115]);
        self::assertEquals(new StyleFrame("\e[38;2;21;0;255m%s\e[39m", 0), $entries[114]);
        self::assertEquals(new StyleFrame("\e[38;2;25;0;255m%s\e[39m", 0), $entries[113]);
        self::assertEquals(new StyleFrame("\e[38;2;29;0;255m%s\e[39m", 0), $entries[112]);
        self::assertEquals(new StyleFrame("\e[38;2;33;0;255m%s\e[39m", 0), $entries[111]);
        self::assertEquals(new StyleFrame("\e[38;2;38;0;255m%s\e[39m", 0), $entries[110]);
        self::assertEquals(new StyleFrame("\e[38;2;42;0;255m%s\e[39m", 0), $entries[109]);
        self::assertEquals(new StyleFrame("\e[38;2;46;0;255m%s\e[39m", 0), $entries[108]);
        self::assertEquals(new StyleFrame("\e[38;2;50;0;255m%s\e[39m", 0), $entries[107]);
        self::assertEquals(new StyleFrame("\e[38;2;55;0;255m%s\e[39m", 0), $entries[106]);
        self::assertEquals(new StyleFrame("\e[38;2;59;0;255m%s\e[39m", 0), $entries[105]);
        self::assertEquals(new StyleFrame("\e[38;2;63;0;255m%s\e[39m", 0), $entries[104]);
        self::assertEquals(new StyleFrame("\e[38;2;67;0;255m%s\e[39m", 0), $entries[103]);
        self::assertEquals(new StyleFrame("\e[38;2;72;0;255m%s\e[39m", 0), $entries[102]);
        self::assertEquals(new StyleFrame("\e[38;2;76;0;255m%s\e[39m", 0), $entries[101]);
        self::assertEquals(new StyleFrame("\e[38;2;80;0;255m%s\e[39m", 0), $entries[100]);
        self::assertEquals(new StyleFrame("\e[38;2;84;0;255m%s\e[39m", 0), $entries[99]);
        self::assertEquals(new StyleFrame("\e[38;2;89;0;255m%s\e[39m", 0), $entries[98]);
        self::assertEquals(new StyleFrame("\e[38;2;93;0;255m%s\e[39m", 0), $entries[97]);
        self::assertEquals(new StyleFrame("\e[38;2;97;0;255m%s\e[39m", 0), $entries[96]);
        self::assertEquals(new StyleFrame("\e[38;2;101;0;255m%s\e[39m", 0), $entries[95]);
        self::assertEquals(new StyleFrame("\e[38;2;106;0;255m%s\e[39m", 0), $entries[94]);
        self::assertEquals(new StyleFrame("\e[38;2;110;0;255m%s\e[39m", 0), $entries[93]);
        self::assertEquals(new StyleFrame("\e[38;2;114;0;255m%s\e[39m", 0), $entries[92]);
        self::assertEquals(new StyleFrame("\e[38;2;119;0;255m%s\e[39m", 0), $entries[91]);
        self::assertEquals(new StyleFrame("\e[38;2;123;0;255m%s\e[39m", 0), $entries[90]);
        self::assertEquals(new StyleFrame("\e[38;2;127;0;255m%s\e[39m", 0), $entries[89]);
        self::assertEquals(new StyleFrame("\e[38;2;131;0;255m%s\e[39m", 0), $entries[88]);
        self::assertEquals(new StyleFrame("\e[38;2;135;0;255m%s\e[39m", 0), $entries[87]);
        self::assertEquals(new StyleFrame("\e[38;2;140;0;255m%s\e[39m", 0), $entries[86]);
        self::assertEquals(new StyleFrame("\e[38;2;144;0;255m%s\e[39m", 0), $entries[85]);
        self::assertEquals(new StyleFrame("\e[38;2;148;0;255m%s\e[39m", 0), $entries[84]);
        self::assertEquals(new StyleFrame("\e[38;2;153;0;255m%s\e[39m", 0), $entries[83]);
        self::assertEquals(new StyleFrame("\e[38;2;157;0;255m%s\e[39m", 0), $entries[82]);
        self::assertEquals(new StyleFrame("\e[38;2;161;0;255m%s\e[39m", 0), $entries[81]);
        self::assertEquals(new StyleFrame("\e[38;2;165;0;255m%s\e[39m", 0), $entries[80]);
        self::assertEquals(new StyleFrame("\e[38;2;170;0;255m%s\e[39m", 0), $entries[79]);
        self::assertEquals(new StyleFrame("\e[38;2;174;0;255m%s\e[39m", 0), $entries[78]);
        self::assertEquals(new StyleFrame("\e[38;2;178;0;255m%s\e[39m", 0), $entries[77]);
        self::assertEquals(new StyleFrame("\e[38;2;182;0;255m%s\e[39m", 0), $entries[76]);
        self::assertEquals(new StyleFrame("\e[38;2;187;0;255m%s\e[39m", 0), $entries[75]);
        self::assertEquals(new StyleFrame("\e[38;2;191;0;255m%s\e[39m", 0), $entries[74]);
        self::assertEquals(new StyleFrame("\e[38;2;195;0;255m%s\e[39m", 0), $entries[73]);
        self::assertEquals(new StyleFrame("\e[38;2;199;0;255m%s\e[39m", 0), $entries[72]);
        self::assertEquals(new StyleFrame("\e[38;2;204;0;255m%s\e[39m", 0), $entries[71]);
        self::assertEquals(new StyleFrame("\e[38;2;208;0;255m%s\e[39m", 0), $entries[70]);
        self::assertEquals(new StyleFrame("\e[38;2;212;0;255m%s\e[39m", 0), $entries[69]);
        self::assertEquals(new StyleFrame("\e[38;2;216;0;255m%s\e[39m", 0), $entries[68]);
        self::assertEquals(new StyleFrame("\e[38;2;221;0;255m%s\e[39m", 0), $entries[67]);
        self::assertEquals(new StyleFrame("\e[38;2;225;0;255m%s\e[39m", 0), $entries[66]);
        self::assertEquals(new StyleFrame("\e[38;2;229;0;255m%s\e[39m", 0), $entries[65]);
        self::assertEquals(new StyleFrame("\e[38;2;233;0;255m%s\e[39m", 0), $entries[64]);
        self::assertEquals(new StyleFrame("\e[38;2;238;0;255m%s\e[39m", 0), $entries[63]);
        self::assertEquals(new StyleFrame("\e[38;2;242;0;255m%s\e[39m", 0), $entries[62]);
        self::assertEquals(new StyleFrame("\e[38;2;246;0;255m%s\e[39m", 0), $entries[61]);
        self::assertEquals(new StyleFrame("\e[38;2;250;0;255m%s\e[39m", 0), $entries[60]);
        self::assertEquals(new StyleFrame("\e[38;2;255;0;255m%s\e[39m", 0), $entries[59]);
        self::assertEquals(new StyleFrame("\e[38;2;255;0;250m%s\e[39m", 0), $entries[58]);
        self::assertEquals(new StyleFrame("\e[38;2;255;0;246m%s\e[39m", 0), $entries[57]);
        self::assertEquals(new StyleFrame("\e[38;2;255;0;242m%s\e[39m", 0), $entries[56]);
        self::assertEquals(new StyleFrame("\e[38;2;255;0;238m%s\e[39m", 0), $entries[55]);
        self::assertEquals(new StyleFrame("\e[38;2;255;0;233m%s\e[39m", 0), $entries[54]);
        self::assertEquals(new StyleFrame("\e[38;2;255;0;229m%s\e[39m", 0), $entries[53]);
        self::assertEquals(new StyleFrame("\e[38;2;255;0;225m%s\e[39m", 0), $entries[52]);
        self::assertEquals(new StyleFrame("\e[38;2;255;0;221m%s\e[39m", 0), $entries[51]);
        self::assertEquals(new StyleFrame("\e[38;2;255;0;216m%s\e[39m", 0), $entries[50]);
        self::assertEquals(new StyleFrame("\e[38;2;255;0;212m%s\e[39m", 0), $entries[49]);
        self::assertEquals(new StyleFrame("\e[38;2;255;0;208m%s\e[39m", 0), $entries[48]);
        self::assertEquals(new StyleFrame("\e[38;2;255;0;203m%s\e[39m", 0), $entries[47]);
        self::assertEquals(new StyleFrame("\e[38;2;255;0;199m%s\e[39m", 0), $entries[46]);
        self::assertEquals(new StyleFrame("\e[38;2;255;0;195m%s\e[39m", 0), $entries[45]);
        self::assertEquals(new StyleFrame("\e[38;2;255;0;191m%s\e[39m", 0), $entries[44]);
        self::assertEquals(new StyleFrame("\e[38;2;255;0;187m%s\e[39m", 0), $entries[43]);
        self::assertEquals(new StyleFrame("\e[38;2;255;0;182m%s\e[39m", 0), $entries[42]);
        self::assertEquals(new StyleFrame("\e[38;2;255;0;178m%s\e[39m", 0), $entries[41]);
        self::assertEquals(new StyleFrame("\e[38;2;255;0;174m%s\e[39m", 0), $entries[40]);
        self::assertEquals(new StyleFrame("\e[38;2;255;0;170m%s\e[39m", 0), $entries[39]);
        self::assertEquals(new StyleFrame("\e[38;2;255;0;165m%s\e[39m", 0), $entries[38]);
        self::assertEquals(new StyleFrame("\e[38;2;255;0;161m%s\e[39m", 0), $entries[37]);
        self::assertEquals(new StyleFrame("\e[38;2;255;0;157m%s\e[39m", 0), $entries[36]);
        self::assertEquals(new StyleFrame("\e[38;2;255;0;152m%s\e[39m", 0), $entries[35]);
        self::assertEquals(new StyleFrame("\e[38;2;255;0;148m%s\e[39m", 0), $entries[34]);
        self::assertEquals(new StyleFrame("\e[38;2;255;0;144m%s\e[39m", 0), $entries[33]);
        self::assertEquals(new StyleFrame("\e[38;2;255;0;140m%s\e[39m", 0), $entries[32]);
        self::assertEquals(new StyleFrame("\e[38;2;255;0;135m%s\e[39m", 0), $entries[31]);
        self::assertEquals(new StyleFrame("\e[38;2;255;0;131m%s\e[39m", 0), $entries[30]);
        self::assertEquals(new StyleFrame("\e[38;2;255;0;127m%s\e[39m", 0), $entries[29]);
        self::assertEquals(new StyleFrame("\e[38;2;255;0;123m%s\e[39m", 0), $entries[28]);
        self::assertEquals(new StyleFrame("\e[38;2;255;0;119m%s\e[39m", 0), $entries[27]);
        self::assertEquals(new StyleFrame("\e[38;2;255;0;114m%s\e[39m", 0), $entries[26]);
        self::assertEquals(new StyleFrame("\e[38;2;255;0;110m%s\e[39m", 0), $entries[25]);
        self::assertEquals(new StyleFrame("\e[38;2;255;0;106m%s\e[39m", 0), $entries[24]);
        self::assertEquals(new StyleFrame("\e[38;2;255;0;102m%s\e[39m", 0), $entries[23]);
        self::assertEquals(new StyleFrame("\e[38;2;255;0;97m%s\e[39m", 0), $entries[22]);
        self::assertEquals(new StyleFrame("\e[38;2;255;0;93m%s\e[39m", 0), $entries[21]);
        self::assertEquals(new StyleFrame("\e[38;2;255;0;89m%s\e[39m", 0), $entries[20]);
        self::assertEquals(new StyleFrame("\e[38;2;255;0;85m%s\e[39m", 0), $entries[19]);
        self::assertEquals(new StyleFrame("\e[38;2;255;0;80m%s\e[39m", 0), $entries[18]);
        self::assertEquals(new StyleFrame("\e[38;2;255;0;76m%s\e[39m", 0), $entries[17]);
        self::assertEquals(new StyleFrame("\e[38;2;255;0;72m%s\e[39m", 0), $entries[16]);
        self::assertEquals(new StyleFrame("\e[38;2;255;0;67m%s\e[39m", 0), $entries[15]);
        self::assertEquals(new StyleFrame("\e[38;2;255;0;63m%s\e[39m", 0), $entries[14]);
        self::assertEquals(new StyleFrame("\e[38;2;255;0;59m%s\e[39m", 0), $entries[13]);
        self::assertEquals(new StyleFrame("\e[38;2;255;0;55m%s\e[39m", 0), $entries[12]);
        self::assertEquals(new StyleFrame("\e[38;2;255;0;51m%s\e[39m", 0), $entries[11]);
        self::assertEquals(new StyleFrame("\e[38;2;255;0;46m%s\e[39m", 0), $entries[10]);
        self::assertEquals(new StyleFrame("\e[38;2;255;0;42m%s\e[39m", 0), $entries[9]);
        self::assertEquals(new StyleFrame("\e[38;2;255;0;38m%s\e[39m", 0), $entries[8]);
        self::assertEquals(new StyleFrame("\e[38;2;255;0;34m%s\e[39m", 0), $entries[7]);
        self::assertEquals(new StyleFrame("\e[38;2;255;0;29m%s\e[39m", 0), $entries[6]);
        self::assertEquals(new StyleFrame("\e[38;2;255;0;25m%s\e[39m", 0), $entries[5]);
        self::assertEquals(new StyleFrame("\e[38;2;255;0;21m%s\e[39m", 0), $entries[4]);
        self::assertEquals(new StyleFrame("\e[38;2;255;0;16m%s\e[39m", 0), $entries[3]);
        self::assertEquals(new StyleFrame("\e[38;2;255;0;12m%s\e[39m", 0), $entries[2]);
        self::assertEquals(new StyleFrame("\e[38;2;255;0;8m%s\e[39m", 0), $entries[1]);
        self::assertEquals(new StyleFrame("\e[38;2;255;0;4m%s\e[39m", 0), $entries[0]);
    }
}
