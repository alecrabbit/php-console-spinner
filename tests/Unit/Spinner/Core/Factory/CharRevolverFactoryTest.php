<?php

declare(strict_types=1);

namespace AlecRabbit\Tests\Unit\Spinner\Core\Factory;

use AlecRabbit\Spinner\Core\Factory\CharRevolverFactory;
use AlecRabbit\Spinner\Core\Factory\Contract\ICharRevolverFactory;
use AlecRabbit\Spinner\Core\Factory\Contract\IIntervalFactory;
use AlecRabbit\Spinner\Core\Render\Contract\ICharFrameCollectionRenderer;
use AlecRabbit\Spinner\Core\Revolver\Contract\IFrameRevolverBuilder;
use AlecRabbit\Tests\TestCase\TestCaseWithPrebuiltMocksAndStubs;
use PHPUnit\Framework\Attributes\Test;

final class CharRevolverFactoryTest extends TestCaseWithPrebuiltMocksAndStubs
{
    #[Test]
    public function canBeCreated(): void
    {
        $charRevolverFactory = $this->getTesteeInstance();

        self::assertInstanceOf(CharRevolverFactory::class, $charRevolverFactory);
    }

    public function getTesteeInstance(
        ?IFrameRevolverBuilder $frameRevolverBuilder = null,
        ?ICharFrameCollectionRenderer $charFrameCollectionRenderer = null,
        ?IIntervalFactory $intervalFactory = null,
    ): ICharRevolverFactory {
        return new CharRevolverFactory(
            frameRevolverBuilder: $frameRevolverBuilder ?? $this->getFrameRevolverBuilderMock(),
            charFrameCollectionRenderer: $charFrameCollectionRenderer ?? $this->getCharFrameCollectionRendererMock(),
            intervalFactory: $intervalFactory ?? $this->getIntervalFactoryMock(),
        );
    }

    #[Test]
    public function canCreateConverter(): void
    {
        $interval = $this->getIntervalMock();
        $interval
            ->expects(self::once())
            ->method('toMilliseconds');

        $pattern = $this->getPatternMock();
        $pattern
            ->expects(self::once())
            ->method('getInterval')
            ->willReturn($interval)
        ;

        $frameCollection = $this->getFrameCollectionMock();

        $charFrameCollectionRenderer = $this->getCharFrameCollectionRendererMock();
        $charFrameCollectionRenderer
            ->expects(self::once())
            ->method('render')
            ->with($pattern)
            ->willReturn($frameCollection)
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
        $frameRevolver = $this->getFrameRevolverMock();
        $frameRevolverBuilder
            ->expects(self::once())
            ->method('build')
            ->willReturn($frameRevolver)
        ;
        $intervalFactory = $this->getIntervalFactoryMock();
        $intervalFactory
            ->expects(self::once())
            ->method('createNormalized')
            ->willReturn($interval)
        ;

        $charRevolverFactory = $this->getTesteeInstance(
            frameRevolverBuilder: $frameRevolverBuilder,
            charFrameCollectionRenderer: $charFrameCollectionRenderer,
            intervalFactory: $intervalFactory,
        );

        $styleRevolver = $charRevolverFactory->createCharRevolver($pattern);
        self::assertInstanceOf(CharRevolverFactory::class, $charRevolverFactory);
        self::assertSame($frameRevolver, $styleRevolver);
    }
}
