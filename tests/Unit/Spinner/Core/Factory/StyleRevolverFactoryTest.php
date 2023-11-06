<?php

declare(strict_types=1);

namespace AlecRabbit\Tests\Unit\Spinner\Core\Factory;

use AlecRabbit\Spinner\Contract\IInterval;
use AlecRabbit\Spinner\Contract\Pattern\IPattern;
use AlecRabbit\Spinner\Core\Config\Contract\IRevolverConfig;
use AlecRabbit\Spinner\Core\Contract\IFrameCollection;
use AlecRabbit\Spinner\Core\Contract\ITolerance;
use AlecRabbit\Spinner\Core\Factory\Contract\IFrameCollectionFactory;
use AlecRabbit\Spinner\Core\Factory\Contract\IIntervalFactory;
use AlecRabbit\Spinner\Core\Factory\Contract\IStyleFrameRevolverFactory;
use AlecRabbit\Spinner\Core\Factory\StyleFrameRevolverFactory;
use AlecRabbit\Spinner\Core\Revolver\Contract\IFrameRevolver;
use AlecRabbit\Spinner\Core\Revolver\Contract\IFrameRevolverBuilder;
use AlecRabbit\Tests\TestCase\TestCase;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\MockObject\MockObject;
use Traversable;

final class StyleRevolverFactoryTest extends TestCase
{
    #[Test]
    public function canBeInstantiated(): void
    {
        $styleRevolverFactory = $this->getTesteeInstance();

        self::assertInstanceOf(StyleFrameRevolverFactory::class, $styleRevolverFactory);
    }

    public function getTesteeInstance(
        ?IFrameRevolverBuilder $frameRevolverBuilder = null,
        ?IFrameCollectionFactory $frameCollectionFactory = null,
        ?IRevolverConfig $revolverConfig = null,
    ): IStyleFrameRevolverFactory {
        return
            new StyleFrameRevolverFactory(
                frameRevolverBuilder: $frameRevolverBuilder ?? $this->getFrameRevolverBuilderMock(),
                frameCollectionFactory: $frameCollectionFactory ?? $this->getFrameCollectionFactoryMock(),
                revolverConfig: $revolverConfig ?? $this->getRevolverConfigMock(),
            );
    }

    protected function getFrameRevolverBuilderMock(): MockObject&IFrameRevolverBuilder
    {
        return $this->createMock(IFrameRevolverBuilder::class);
    }

    protected function getFrameCollectionFactoryMock(): MockObject&IFrameCollectionFactory
    {
        return $this->createMock(IFrameCollectionFactory::class);
    }

    private function getRevolverConfigMock(): MockObject&IRevolverConfig
    {
        return $this->createMock(IRevolverConfig::class);
    }

    #[Test]
    public function canCreate(): void
    {
        $interval = $this->getIntervalMock();
        $frames = $this->getTraversableMock();
        $tolerance = $this->getToleranceMock();
        $pattern = $this->getPatternMock();
        $pattern
            ->expects(self::once())
            ->method('getInterval')
            ->willReturn($interval)
        ;
        $pattern
            ->expects(self::once())
            ->method('getFrames')
            ->willReturn($frames)
        ;
        $frameCollection = $this->getFrameCollectionMock();
        $frameCollectionFactory = $this->getFrameCollectionFactoryMock();
        $frameCollectionFactory
            ->expects(self::once())
            ->method('create')
            ->with($frames)
            ->willReturn($frameCollection)
        ;

        $frameRevolverBuilder = $this->getFrameRevolverBuilderMock();
        $frameRevolverBuilder
            ->expects(self::once())
            ->method('withFrameCollection')
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

        $frameRevolver = $this->getFrameRevolverMock();
        $frameRevolverBuilder
            ->expects(self::once())
            ->method('build')
            ->willReturn($frameRevolver)
        ;

        $revolverConfig = $this->getRevolverConfigMock();
        $revolverConfig
            ->expects(self::once())
            ->method('getTolerance')
            ->willReturn($tolerance)
        ;

        $styleRevolverFactory =
            $this->getTesteeInstance(
                frameRevolverBuilder: $frameRevolverBuilder,
                frameCollectionFactory: $frameCollectionFactory,
                revolverConfig: $revolverConfig,
            );

        self::assertInstanceOf(StyleFrameRevolverFactory::class, $styleRevolverFactory);

        self::assertSame(
            $frameRevolver,
            $styleRevolverFactory->create($pattern),
        );
    }

    private function getIntervalMock(): MockObject&IInterval
    {
        return $this->createMock(IInterval::class);
    }

    private function getTraversableMock(): MockObject&Traversable
    {
        return $this->createMock(Traversable::class);
    }

    private function getToleranceMock(): MockObject&ITolerance
    {
        return $this->createMock(ITolerance::class);
    }

    private function getPatternMock(): MockObject&IPattern
    {
        return $this->createMock(IPattern::class);
    }

    private function getFrameCollectionMock(): MockObject&IFrameCollection
    {
        return $this->createMock(IFrameCollection::class);
    }

    private function getFrameRevolverMock(): MockObject&IFrameRevolver
    {
        return $this->createMock(IFrameRevolver::class);
    }

    protected function getIntervalFactoryMock(): MockObject&IIntervalFactory
    {
        return $this->createMock(IIntervalFactory::class);
    }
}
