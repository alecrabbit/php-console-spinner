<?php

declare(strict_types=1);

namespace AlecRabbit\Tests\Spinner\Unit\Core\Pattern\Factory;

use AlecRabbit\Spinner\Contract\IStyleFrameTransformer;
use AlecRabbit\Spinner\Core\Factory\Contract\IIntervalFactory;
use AlecRabbit\Spinner\Core\Palette\Contract\IPalette;
use AlecRabbit\Spinner\Core\Palette\Contract\IPaletteOptions;
use AlecRabbit\Spinner\Core\Pattern\Factory\Contract\IStylePatternFactory;
use AlecRabbit\Spinner\Core\Pattern\Factory\StylePatternFactory;
use AlecRabbit\Spinner\Core\Pattern\NeoStylePattern;
use AlecRabbit\Tests\TestCase\TestCase;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\MockObject\MockObject;

final class StylePatternFactoryTest extends TestCase
{
    #[Test]
    public function canBeInstantiated(): void
    {
        $factory = $this->getTesteeInstance();

        self::assertInstanceOf(StylePatternFactory::class, $factory);
    }

    public function getTesteeInstance(
        ?IIntervalFactory $intervalFactory = null,
        ?IStyleFrameTransformer $transformer = null,
    ): IStylePatternFactory {
        return
            new StylePatternFactory(
                intervalFactory: $intervalFactory ?? $this->getIntervalFactoryMock(),
                transformer: $transformer ?? $this->getStyleFrameTransformerMock(),
            );
    }

    private function getIntervalFactoryMock(): MockObject&IIntervalFactory
    {
        return $this->createMock(IIntervalFactory::class);
    }

    private function getStyleFrameTransformerMock(): MockObject&IStyleFrameTransformer
    {
        return $this->createMock(IStyleFrameTransformer::class);
    }

    #[Test]
    public function canCreate(): void
    {
        $intInterval = 142;

        $paletteOptions = $this->getPaletteOptionsMock();
        $paletteOptions
            ->expects($this->once())
            ->method('getInterval')
            ->willReturn($intInterval)
        ;

        $palette = $this->getNeoPaletteMock();
        $palette
            ->expects($this->once())
            ->method('getOptions')
            ->willReturn($paletteOptions)
        ;

        $intervalFactory = $this->getIntervalFactoryMock();
        $intervalFactory
            ->expects($this->once())
            ->method('createNormalized')
            ->with($intInterval)
        ;
        $factory = $this->getTesteeInstance(
            intervalFactory: $intervalFactory,
        );

        $pattern = $factory->create($palette);

        self::assertInstanceOf(NeoStylePattern::class, $pattern);
    }

    private function getPaletteOptionsMock(): MockObject&IPaletteOptions
    {
        return $this->createMock(IPaletteOptions::class);
    }

    private function getNeoPaletteMock(): MockObject&IPalette
    {
        return $this->createMock(IPalette::class);
    }
}
