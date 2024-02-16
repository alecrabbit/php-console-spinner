<?php

declare(strict_types=1);

namespace AlecRabbit\Tests\Spinner\Unit\Core\Factory;

use AlecRabbit\Spinner\Contract\IInterval;
use AlecRabbit\Spinner\Contract\Pattern\IPattern;
use AlecRabbit\Spinner\Core\Config\Contract\IRevolverConfig;
use AlecRabbit\Spinner\Core\Contract\IFrameCollection;
use AlecRabbit\Spinner\Core\Contract\ITolerance;
use AlecRabbit\Spinner\Core\Factory\CharFrameRevolverFactory;
use AlecRabbit\Spinner\Core\Factory\Contract\ICharFrameRevolverFactory;
use AlecRabbit\Spinner\Core\Factory\Contract\IFrameCollectionFactory;
use AlecRabbit\Spinner\Core\Factory\Contract\IIntervalFactory;
use AlecRabbit\Spinner\Core\Palette\Contract\IPalette;
use AlecRabbit\Spinner\Core\Pattern\Factory\Contract\IPatternFactory;
use AlecRabbit\Spinner\Core\Revolver\Contract\IFrameCollectionRevolver;
use AlecRabbit\Spinner\Core\Revolver\Contract\IFrameCollectionRevolverBuilder;
use AlecRabbit\Tests\TestCase\TestCase;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\MockObject\MockObject;
use Traversable;

final class CharRevolverFactoryTest extends TestCase
{
    #[Test]
    public function canBeInstantiated(): void
    {
        $charRevolverFactory = $this->getTesteeInstance();

        self::assertInstanceOf(CharFrameRevolverFactory::class, $charRevolverFactory);
    }

    public function getTesteeInstance(
        ?IFrameCollectionRevolverBuilder $frameRevolverBuilder = null,
        ?IFrameCollectionFactory $frameCollectionFactory = null,
        ?IPatternFactory $patternFactory = null,
        ?IRevolverConfig $revolverConfig = null,
    ): ICharFrameRevolverFactory {
        return
            new CharFrameRevolverFactory(
                frameRevolverBuilder: $frameRevolverBuilder ?? $this->getFrameRevolverBuilderMock(),
                frameCollectionFactory: $frameCollectionFactory ?? $this->getFrameCollectionFactoryMock(),
                patternFactory: $patternFactory ?? $this->getPatternFactoryMock(),
                revolverConfig: $revolverConfig ?? $this->getRevolverConfigMock(),
            );
    }

    protected function getFrameRevolverBuilderMock(): MockObject&IFrameCollectionRevolverBuilder
    {
        return $this->createMock(IFrameCollectionRevolverBuilder::class);
    }

    protected function getFrameCollectionFactoryMock(): MockObject&IFrameCollectionFactory
    {
        return $this->createMock(IFrameCollectionFactory::class);
    }

    private function getPatternFactoryMock(): MockObject&IPatternFactory
    {
        return $this->createMock(IPatternFactory::class);
    }

    private function getRevolverConfigMock(): MockObject&IRevolverConfig
    {
        return $this->createMock(IRevolverConfig::class);
    }

    #[Test]
    public function canCreate(): void
    {
        $tolerance = $this->getToleranceMock();
        $palette = $this->getPaletteMock();

        $frames = $this->getTraversableMock();
        $interval = $this->getIntervalMock();
        $pattern = $this->getPatternMock();
        $pattern
            ->expects(self::once())
            ->method('getFrames')
            ->willReturn($frames)
        ;
        $pattern
            ->expects(self::once())
            ->method('getInterval')
            ->willReturn($interval)
        ;

        $patternFactory = $this->getPatternFactoryMock();
        $patternFactory
            ->expects(self::once())
            ->method('create')
            ->with($palette)
            ->willReturn($pattern)
        ;

        $frameCollection = $this->getFrameCollectionMock();
        $frameCollectionFactory = $this->getFrameCollectionFactoryMock();
        $frameCollectionFactory
            ->expects(self::once())
            ->method('create')
            ->with($frames)
            ->willReturn($frameCollection)
        ;

        $revolverConfig = $this->getRevolverConfigMock();
        $revolverConfig
            ->expects(self::once())
            ->method('getTolerance')
            ->willReturn($tolerance)
        ;

        $frameRevolverBuilder = $this->getFrameRevolverBuilderMock();
        $frameRevolverBuilder
            ->expects(self::once())
            ->method('withFrames')
            ->with($frameCollection)
            ->willReturnSelf()
        ;
        $frameRevolverBuilder
            ->expects(self::once())
            ->method('withInterval')
            ->with($interval)
            ->willReturnSelf()
        ;
        $frameRevolverBuilder
            ->expects(self::once())
            ->method('withTolerance')
            ->with($tolerance)
            ->willReturnSelf()
        ;

        $frameRevolver = $this->getFrameCollectionRevolverMock();
        $frameRevolverBuilder
            ->expects(self::once())
            ->method('build')
            ->willReturn($frameRevolver)
        ;

        $styleRevolverFactory =
            $this->getTesteeInstance(
                frameRevolverBuilder: $frameRevolverBuilder,
                frameCollectionFactory: $frameCollectionFactory,
                patternFactory: $patternFactory,
                revolverConfig: $revolverConfig,
            );

        self::assertInstanceOf(CharFrameRevolverFactory::class, $styleRevolverFactory);

        self::assertSame(
            $frameRevolver,
            $styleRevolverFactory->create($palette),
        );
    }

    private function getToleranceMock(): MockObject&ITolerance
    {
        return $this->createMock(ITolerance::class);
    }

    private function getPaletteMock(): MockObject&IPalette
    {
        return $this->createMock(IPalette::class);
    }

    private function getTraversableMock(): MockObject&Traversable
    {
        return $this->createMock(Traversable::class);
    }

    private function getIntervalMock(): MockObject&IInterval
    {
        return $this->createMock(IInterval::class);
    }

    private function getPatternMock(): MockObject&IPattern
    {
        return $this->createMock(IPattern::class);
    }

    private function getFrameCollectionMock(): MockObject&IFrameCollection
    {
        return $this->createMock(IFrameCollection::class);
    }

    private function getFrameCollectionRevolverMock(): MockObject&IFrameCollectionRevolver
    {
        return $this->createMock(IFrameCollectionRevolver::class);
    }

    protected function getIntervalFactoryMock(): MockObject&IIntervalFactory
    {
        return $this->createMock(IIntervalFactory::class);
    }
}
