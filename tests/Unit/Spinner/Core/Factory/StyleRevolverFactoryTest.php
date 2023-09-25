<?php

declare(strict_types=1);

namespace AlecRabbit\Tests\Unit\Spinner\Core\Factory;

use AlecRabbit\Spinner\Contract\Option\StylingMethodOption;
use AlecRabbit\Spinner\Core\Factory\Contract\IFrameCollectionFactory;
use AlecRabbit\Spinner\Core\Factory\Contract\IIntervalFactory;
use AlecRabbit\Spinner\Core\Factory\Contract\IStyleFrameRevolverFactory;
use AlecRabbit\Spinner\Core\Factory\StyleFrameRevolverFactory;
use AlecRabbit\Spinner\Core\Revolver\Contract\IFrameRevolverBuilder;
use AlecRabbit\Spinner\Core\Revolver\Tolerance;
use AlecRabbit\Tests\TestCase\TestCaseWithPrebuiltMocksAndStubs;
use ArrayObject;
use PHPUnit\Framework\Attributes\Test;

final class StyleRevolverFactoryTest extends TestCaseWithPrebuiltMocksAndStubs
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
        ?IIntervalFactory $intervalFactory = null,
        ?StylingMethodOption $styleMode = null,
    ): IStyleFrameRevolverFactory {
        return
            new StyleFrameRevolverFactory(
                frameRevolverBuilder: $frameRevolverBuilder ?? $this->getFrameRevolverBuilderMock(),
                frameCollectionFactory: $frameCollectionFactory ?? $this->getFrameCollectionFactoryMock(),
                intervalFactory: $intervalFactory ?? $this->getIntervalFactoryMock(),
                styleMode: $styleMode ?? StylingMethodOption::NONE,
            );
    }

    #[Test]
    public function canCreateRevolver(): void
    {
        $styleMode = StylingMethodOption::ANSI8;
        $intInterval = 100;

        $pattern = $this->getStylePatternMock();
        $interval = $this->getIntervalMock();

        $pattern
            ->expects(self::once())
            ->method('getEntries')
            ->with($styleMode)
            ->willReturn(new ArrayObject([$this->getFrameMock()]))
        ;
        $pattern
            ->expects(self::once())
            ->method('getInterval')
            ->willReturn($intInterval)
        ;
        $frameCollection = $this->getFrameCollectionMock();

        $frameCollectionFactory = $this->getFrameCollectionFactoryMock();
        $frameCollectionFactory
            ->expects(self::once())
            ->method('create')
            ->willReturn($this->getFrameCollectionMock())
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
            ->with(self::identicalTo($interval))
            ->willReturnSelf()
        ;
        $frameRevolverBuilder
            ->expects(self::once())
            ->method('withTolerance')
            ->with(self::equalTo(new Tolerance())) // [fd86d318-9069-47e2-b60d-a68f537be4a3]
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

        $styleRevolverFactory = $this->getTesteeInstance(
            frameRevolverBuilder: $frameRevolverBuilder,
            frameCollectionFactory: $frameCollectionFactory,
            intervalFactory: $intervalFactory,
            styleMode: $styleMode,
        );

        $styleRevolver = $styleRevolverFactory->createStyleRevolver($pattern);
        self::assertInstanceOf(StyleFrameRevolverFactory::class, $styleRevolverFactory);
        self::assertSame($frameRevolver, $styleRevolver);
    }

    #[Test]
    public function canCreateRevolverInStyleModeNone(): void
    {
        $pattern = $this->getStylePatternMock();
        $pattern
            ->expects(self::never())
            ->method('getInterval')
        ;


        $frameRevolverBuilder = $this->getFrameRevolverBuilderMock();
        $frameRevolverBuilder
            ->expects(self::once())
            ->method('withFrameCollection')
            ->willReturnSelf()
        ;
        $frameRevolverBuilder
            ->expects(self::once())
            ->method('withInterval')
            ->willReturnSelf()
        ;
        $frameRevolverBuilder
            ->expects(self::once())
            ->method('withTolerance')
            ->with(self::equalTo(new Tolerance())) // [fd86d318-9069-47e2-b60d-a68f537be4a3]
            ->willReturnSelf()
        ;
        $frameRevolver = $this->getFrameRevolverMock();
        $frameRevolverBuilder
            ->expects(self::once())
            ->method('build')
            ->willReturn($frameRevolver)
        ;

        $styleMode = StylingMethodOption::NONE;

        $intervalFactory = $this->getIntervalFactoryMock();
        $intervalFactory
            ->expects(self::once())
            ->method('createNormalized')
        ;

        $frameCollectionFactory = $this->getFrameCollectionFactoryMock();
        $frameCollectionFactory
            ->expects(self::once())
            ->method('create')
            ->willReturn($this->getFrameCollectionMock())
        ;

        $styleRevolverFactory = $this->getTesteeInstance(
            frameRevolverBuilder: $frameRevolverBuilder,
            frameCollectionFactory: $frameCollectionFactory,
            intervalFactory: $intervalFactory,
            styleMode: $styleMode,
        );

        $styleRevolver = $styleRevolverFactory->createStyleRevolver($pattern);
        self::assertInstanceOf(StyleFrameRevolverFactory::class, $styleRevolverFactory);
        self::assertSame($frameRevolver, $styleRevolver);
    }
}
