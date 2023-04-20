<?php

declare(strict_types=1);

namespace AlecRabbit\Tests\Unit\Spinner\Core\Factory;

use AlecRabbit\Spinner\Contract\Option\OptionStyleMode;
use AlecRabbit\Spinner\Core\Factory\Contract\IIntervalFactory;
use AlecRabbit\Spinner\Core\Factory\Contract\IStyleRevolverFactory;
use AlecRabbit\Spinner\Core\Factory\StyleRevolverFactory;
use AlecRabbit\Spinner\Core\Render\Contract\IStyleFrameCollectionRenderer;
use AlecRabbit\Spinner\Core\Revolver\Contract\IFrameRevolverBuilder;
use AlecRabbit\Tests\TestCase\TestCaseWithPrebuiltMocksAndStubs;
use PHPUnit\Framework\Attributes\Test;

final class StyleRevolverFactoryTest extends TestCaseWithPrebuiltMocksAndStubs
{
    #[Test]
    public function canBeCreated(): void
    {
        $styleRevolverFactory = $this->getTesteeInstance();

        self::assertInstanceOf(StyleRevolverFactory::class, $styleRevolverFactory);
    }

    public function getTesteeInstance(
        ?IFrameRevolverBuilder $frameRevolverBuilder = null,
        ?IStyleFrameCollectionRenderer $styleFrameCollectionRenderer = null,
        ?IIntervalFactory $intervalFactory = null,
        ?OptionStyleMode $styleMode = null,
    ): IStyleRevolverFactory {
        return new StyleRevolverFactory(
            frameRevolverBuilder: $frameRevolverBuilder ?? $this->getFrameRevolverBuilderMock(),
            styleFrameCollectionRenderer: $styleFrameCollectionRenderer ?? $this->getStyleFrameCollectionRendererMock(),
            intervalFactory: $intervalFactory ?? $this->getIntervalFactoryMock(),
            styleMode: $styleMode ?? OptionStyleMode::NONE,
        );
    }

    #[Test]
    public function canCreateConverter(): void
    {
        $pattern = $this->getStylePatternMock();
        $interval = $this->getIntervalMock();
        $interval
            ->expects(self::once())
            ->method('toMilliseconds')
        ;
        
        $pattern
            ->expects(self::once())
            ->method('getInterval')
            ->willReturn($interval)
        ;
        $frameCollection = $this->getFrameCollectionMock();

        $styleFrameCollectionRenderer = $this->getStyleFrameCollectionRendererMock();
        $styleFrameCollectionRenderer
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

        $styleMode = OptionStyleMode::ANSI8;

        $intervalFactory = $this->getIntervalFactoryMock();
        $intervalFactory
            ->expects(self::once())
            ->method('createNormalized')
            ->willReturn($interval)
        ;

        $styleRevolverFactory = $this->getTesteeInstance(
            frameRevolverBuilder: $frameRevolverBuilder,
            styleFrameCollectionRenderer: $styleFrameCollectionRenderer,
            intervalFactory: $intervalFactory,
            styleMode: $styleMode,
        );

        $styleRevolver = $styleRevolverFactory->createStyleRevolver($pattern);
        self::assertInstanceOf(StyleRevolverFactory::class, $styleRevolverFactory);
        self::assertSame($frameRevolver, $styleRevolver);
    }
}
