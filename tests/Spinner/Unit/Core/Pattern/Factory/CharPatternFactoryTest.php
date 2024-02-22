<?php

declare(strict_types=1);

namespace AlecRabbit\Tests\Spinner\Unit\Core\Pattern\Factory;

use AlecRabbit\Spinner\Contract\ICharFrameTransformer;
use AlecRabbit\Spinner\Core\Config\Contract\IRevolverConfig;
use AlecRabbit\Spinner\Core\Contract\IHasFrameWrapper;
use AlecRabbit\Spinner\Core\Factory\Contract\IIntervalFactory;
use AlecRabbit\Spinner\Core\Palette\Contract\IPalette;
use AlecRabbit\Spinner\Core\Palette\Contract\IPaletteOptions;
use AlecRabbit\Spinner\Core\Pattern\CharPattern;
use AlecRabbit\Spinner\Core\Pattern\Factory\CharPatternFactory;
use AlecRabbit\Spinner\Core\Pattern\Factory\Contract\ICharPatternFactory;
use AlecRabbit\Tests\TestCase\TestCase;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\MockObject\MockObject;

final class CharPatternFactoryTest extends TestCase
{
    #[Test]
    public function canBeInstantiated(): void
    {
        $factory = $this->getTesteeInstance();

        self::assertInstanceOf(CharPatternFactory::class, $factory);
    }

    public function getTesteeInstance(
        ?IIntervalFactory $intervalFactory = null,
        ?ICharFrameTransformer $transformer = null,
        ?IHasFrameWrapper $wrapper = null,
        ?IRevolverConfig $revolverConfig = null,
    ): ICharPatternFactory {
        return
            new CharPatternFactory(
                intervalFactory: $intervalFactory ?? $this->getIntervalFactoryMock(),
                transformer: $transformer ?? $this->getCharFrameTransformerMock(),
                wrapper: $wrapper ?? $this->getHasFrameWrapperMock(),
                revolverConfig: $revolverConfig ?? $this->getRevolverConfigMock(),
            );
    }

    private function getIntervalFactoryMock(): MockObject&IIntervalFactory
    {
        return $this->createMock(IIntervalFactory::class);
    }

    private function getCharFrameTransformerMock(): MockObject&ICharFrameTransformer
    {
        return $this->createMock(ICharFrameTransformer::class);
    }

    private function getHasFrameWrapperMock(): MockObject&IHasFrameWrapper
    {
        return $this->createMock(IHasFrameWrapper::class);
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

        $palette = $this->getPaletteMock();
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
        $wrapper = $this->getHasFrameWrapperMock();
//        $wrapper
//            ->expects($this->once())
//            ->method('wrap')
//            ->with($palette)
//            ->willReturn($palette)
//        ;

        $factory = $this->getTesteeInstance(
            intervalFactory: $intervalFactory,
            wrapper: $wrapper,
        );

        $pattern = $factory->create($palette);

        self::assertInstanceOf(CharPattern::class, $pattern);
    }

    private function getPaletteOptionsMock(): MockObject&IPaletteOptions
    {
        return $this->createMock(IPaletteOptions::class);
    }

    private function getPaletteMock(): MockObject&IPalette
    {
        return $this->createMock(IPalette::class);
    }

    private function getRevolverConfigMock(): MockObject&IRevolverConfig
    {
        return $this->createMock(IRevolverConfig::class);
    }
}
