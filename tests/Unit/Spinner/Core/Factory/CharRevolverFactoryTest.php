<?php

declare(strict_types=1);

namespace AlecRabbit\Tests\Unit\Spinner\Core\Factory;

use AlecRabbit\Spinner\Core\Factory\CharFrameRevolverFactory;
use AlecRabbit\Spinner\Core\Factory\Contract\ICharFrameRevolverFactory;
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

        self::assertInstanceOf(CharFrameRevolverFactory::class, $charRevolverFactory);
    }

    public function getTesteeInstance(
        ?IFrameRevolverBuilder $frameRevolverBuilder = null,
        ?ICharFrameCollectionRenderer $charFrameCollectionRenderer = null,
        ?IIntervalFactory $intervalFactory = null,
    ): ICharFrameRevolverFactory {
        return new CharFrameRevolverFactory(
            frameRevolverBuilder: $frameRevolverBuilder ?? $this->getFrameRevolverBuilderMock(),
            frameCollectionRenderer: $charFrameCollectionRenderer ?? $this->getCharFrameCollectionRendererMock(),
            intervalFactory: $intervalFactory ?? $this->getIntervalFactoryMock(),
        );
    }

    #[Test]
    public function canCreateConverter(): void
    {
        $intInterval = 100;
        $interval = $this->getIntervalMock();


        $pattern = $this->getPatternMock();
        $pattern
            ->expects(self::once())
            ->method('getInterval')
            ->willReturn($intInterval)
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
        self::assertInstanceOf(CharFrameRevolverFactory::class, $charRevolverFactory);
        self::assertSame($frameRevolver, $styleRevolver);
    }
}
