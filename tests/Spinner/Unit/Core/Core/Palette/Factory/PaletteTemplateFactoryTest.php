<?php

declare(strict_types=1);

namespace AlecRabbit\Tests\Spinner\Unit\Core\Core\Palette\Factory;

use AlecRabbit\Spinner\Core\Palette\Builder\Contract\IPaletteTemplateBuilder;
use AlecRabbit\Spinner\Core\Palette\Contract\IPalette;
use AlecRabbit\Spinner\Core\Palette\Contract\IPaletteMode;
use AlecRabbit\Spinner\Core\Palette\Contract\IPaletteOptions;
use AlecRabbit\Spinner\Core\Palette\Contract\IPaletteTemplate;
use AlecRabbit\Spinner\Core\Palette\Factory\Contract\IPaletteModeFactory;
use AlecRabbit\Spinner\Core\Palette\Factory\Contract\IPaletteTemplateFactory;
use AlecRabbit\Spinner\Core\Palette\Factory\PaletteTemplateFactory;
use AlecRabbit\Tests\TestCase\TestCase;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\MockObject\MockObject;
use Traversable;

final class PaletteTemplateFactoryTest extends TestCase
{
    #[Test]
    public function canBeInstantiated(): void
    {
        $factory = $this->getTesteeInstance();
        self::assertInstanceOf(PaletteTemplateFactory::class, $factory);
    }

    private function getTesteeInstance(
        ?IPaletteTemplateBuilder $builder = null,
        ?IPaletteModeFactory $paletteModeFactory = null,
    ): IPaletteTemplateFactory {
        return new PaletteTemplateFactory(
            builder: $builder ?? $this->getPaletteTemplateBuilderMock(),
            paletteModeFactory: $paletteModeFactory ?? $this->getPaletteModeFactoryMock(),
        );
    }

    private function getPaletteTemplateBuilderMock(): MockObject&IPaletteTemplateBuilder
    {
        return $this->createMock(IPaletteTemplateBuilder::class);
    }

    private function getPaletteModeFactoryMock(): MockObject&IPaletteModeFactory
    {
        return $this->createMock(IPaletteModeFactory::class);
    }

//    #[Test]
//    public function canCreate(): void
//    {
//        $mode = $this->getPaletteModeMock();
//        $entries = $this->getTraversableMock();
//        $paletteOptions = $this->getPaletteOptionsMock();
//
//        $palette = $this->getPaletteMock();
//
//        $palette
//            ->expects(self::once())
//            ->method('getEntries')
//            ->with($mode)
//            ->willReturn($entries)
//        ;
//        $palette
//            ->expects(self::once())
//            ->method('getOptions')
//            ->with($mode)
//            ->willReturn($paletteOptions)
//        ;
//
//        $template = $this->getPaletteTemplateMock();
//
//        $builder = $this->getPaletteTemplateBuilderMock();
//        $builder
//            ->expects(self::once())
//            ->method('withEntries')
//            ->with($entries)
//            ->willReturnSelf()
//        ;
//        $builder
//            ->expects(self::once())
//            ->method('withOptions')
//            ->with($paletteOptions)
//            ->willReturnSelf()
//        ;
//        $builder
//            ->expects(self::once())
//            ->method('build')
//            ->willReturn($template)
//        ;
//
//        $paletteModeFactory = $this->getPaletteModeFactoryMock();
//        $paletteModeFactory
//            ->expects(self::once())
//            ->method('create')
//            ->willReturn($mode)
//        ;
//
//        $factory = $this->getTesteeInstance(
//            builder: $builder,
//            paletteModeFactory: $paletteModeFactory,
//        );
//
//
//        self::assertSame($template, $factory->create($palette));
//    }

    private function getPaletteModeMock(): MockObject&IPaletteMode
    {
        return $this->createMock(IPaletteMode::class);
    }

    private function getTraversableMock(): MockObject&Traversable
    {
        return $this->createMock(Traversable::class);
    }

    private function getPaletteOptionsMock(): MockObject&IPaletteOptions
    {
        return $this->createMock(IPaletteOptions::class);
    }

    private function getPaletteMock(): MockObject&IPalette
    {
        return $this->createMock(IPalette::class);
    }

    private function getPaletteTemplateMock(): MockObject&IPaletteTemplate
    {
        return $this->createMock(IPaletteTemplate::class);
    }
}
