<?php

declare(strict_types=1);

namespace AlecRabbit\Tests\Unit\Spinner\Core\Factory;

use AlecRabbit\Spinner\Contract\Option\OptionStyleMode;
use AlecRabbit\Spinner\Core\Factory\Contract\IIntervalFactory;
use AlecRabbit\Spinner\Core\Factory\Contract\IStyleFrameRevolverFactory;
use AlecRabbit\Spinner\Core\Factory\StyleFrameRevolverFactory;
use AlecRabbit\Spinner\Core\Render\Contract\IStyleFrameCollectionRenderer;
use AlecRabbit\Spinner\Core\Revolver\Contract\IFrameRevolverBuilder;
use AlecRabbit\Spinner\Core\Revolver\Contract\IRevolver;
use AlecRabbit\Tests\TestCase\TestCaseWithPrebuiltMocksAndStubs;
use PHPUnit\Framework\Attributes\Test;

final class StyleRevolverFactoryTest extends TestCaseWithPrebuiltMocksAndStubs
{
    #[Test]
    public function canBeCreated(): void
    {
        $styleRevolverFactory = $this->getTesteeInstance();

        self::assertInstanceOf(StyleFrameRevolverFactory::class, $styleRevolverFactory);
    }

    public function getTesteeInstance(
        ?IFrameRevolverBuilder $frameRevolverBuilder = null,
        ?IStyleFrameCollectionRenderer $styleFrameCollectionRenderer = null,
        ?IIntervalFactory $intervalFactory = null,
        ?OptionStyleMode $styleMode = null,
    ): IStyleFrameRevolverFactory {
        return new StyleFrameRevolverFactory(
            frameRevolverBuilder: $frameRevolverBuilder ?? $this->getFrameRevolverBuilderMock(),
            frameCollectionRenderer: $styleFrameCollectionRenderer ?? $this->getStyleFrameCollectionRendererMock(),
            intervalFactory: $intervalFactory ?? $this->getIntervalFactoryMock(),
            styleMode: $styleMode ?? OptionStyleMode::NONE,
        );
    }

    #[Test]
    public function canCreateConverter(): void
    {
        $intInterval = 100;

        $pattern = $this->getStylePatternMock();
        $interval = $this->getIntervalMock();

        $pattern
            ->expects(self::once())
            ->method('getInterval')
            ->willReturn($intInterval)
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
            ->with(self::identicalTo(IRevolver::TOLERANCE)) // [fd86d318-9069-47e2-b60d-a68f537be4a3]
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
        self::assertInstanceOf(StyleFrameRevolverFactory::class, $styleRevolverFactory);
        self::assertSame($frameRevolver, $styleRevolver);
    }
}
