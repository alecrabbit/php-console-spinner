<?php

declare(strict_types=1);

namespace AlecRabbit\Tests\Unit\Spinner\Core\Factory;

use AlecRabbit\Spinner\Core\Factory\CharFrameRevolverFactory;
use AlecRabbit\Spinner\Core\Factory\Contract\ICharFrameRevolverFactory;
use AlecRabbit\Spinner\Core\Factory\Contract\IFrameCollectionFactory;
use AlecRabbit\Spinner\Core\Factory\Contract\IIntervalFactory;
use AlecRabbit\Spinner\Core\Revolver\Contract\IFrameRevolverBuilder;
use AlecRabbit\Spinner\Core\Revolver\Contract\IRevolver;
use AlecRabbit\Tests\TestCase\TestCaseWithPrebuiltMocksAndStubs;
use ArrayObject;
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
        ?IFrameCollectionFactory $frameCollectionFactory = null,
        ?IIntervalFactory $intervalFactory = null,
    ): ICharFrameRevolverFactory {
        return new CharFrameRevolverFactory(
            frameRevolverBuilder: $frameRevolverBuilder ?? $this->getFrameRevolverBuilderMock(),
            frameCollectionFactory: $frameCollectionFactory ?? $this->getFrameCollectionFactoryMock(),
            intervalFactory: $intervalFactory ?? $this->getIntervalFactoryMock(),
        );
    }

    #[Test]
    public function canCreateRevolver(): void
    {
        $intInterval = 100;
        $interval = $this->getIntervalMock();


        $pattern = $this->getCharPatternMock();
        $pattern
            ->expects(self::once())
            ->method('getEntries')
            ->willReturn(
                new ArrayObject([$this->getFrameMock()])
            )
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
            ->with(self::identicalTo(IRevolver::TOLERANCE)) // [fd86d318-9069-47e2-b60d-a68f537be4a3]
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
            frameCollectionFactory: $frameCollectionFactory,
            intervalFactory: $intervalFactory,
        );

        $styleRevolver = $charRevolverFactory->createCharRevolver($pattern);
        self::assertInstanceOf(CharFrameRevolverFactory::class, $charRevolverFactory);
        self::assertSame($frameRevolver, $styleRevolver);
    }
}
