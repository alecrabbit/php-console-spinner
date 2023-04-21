<?php

declare(strict_types=1);

namespace AlecRabbit\Tests\Unit\Spinner\Core\Revolver;

use AlecRabbit\Spinner\Contract\IInterval;
use AlecRabbit\Spinner\Core\Contract\IFrameCollection;
use AlecRabbit\Spinner\Core\Revolver\Contract\IFrameCollectionRevolver;
use AlecRabbit\Spinner\Core\Revolver\FrameCollectionRevolver;
use AlecRabbit\Spinner\Exception\InvalidArgumentException;
use AlecRabbit\Tests\TestCase\TestCaseWithPrebuiltMocksAndStubs;
use PHPUnit\Framework\Attributes\Test;

final class FrameCollectionRevolverTest extends TestCaseWithPrebuiltMocksAndStubs
{
    #[Test]
    public function canBeCreated(): void
    {
        $frameCollectionRevolver = $this->getTesteeInstance();

        self::assertInstanceOf(FrameCollectionRevolver::class, $frameCollectionRevolver);
    }

    public function getTesteeInstance(
        ?IFrameCollection $frameCollection = null,
        ?IInterval $interval = null,
    ): IFrameCollectionRevolver {
        return
            new FrameCollectionRevolver(
                frameCollection: $frameCollection ?? $this->getOneElementFrameCollectionMock(),
                interval: $interval ?? $this->getIntervalMock(),
            );
    }

    #[Test]
    public function ifCollectionHasOnlyOneElementOffsetIsAlwaysZero(): void
    {
        $frameCollectionRevolver = $this->getTesteeInstance();

        self::assertInstanceOf(FrameCollectionRevolver::class, $frameCollectionRevolver);
        self::assertEquals(0, self::getPropertyValue('offset', $frameCollectionRevolver));
        self::callMethod($frameCollectionRevolver, 'next');
        self::assertEquals(0, self::getPropertyValue('offset', $frameCollectionRevolver));
        self::callMethod($frameCollectionRevolver, 'next');
        self::assertEquals(0, self::getPropertyValue('offset', $frameCollectionRevolver));
    }


    #[Test]
    public function canUpdate(): void
    {
        $frameCollection = $this->getFrameCollectionMock();
        $frameCollection
            ->expects(self::once())
            ->method('count')
            ->willReturn(3)
        ;
        $frame0 = $this->getFrameMock();
        $frame1 = $this->getFrameMock();
        $frame2 = $this->getFrameMock();
        $frameCollection
            ->expects(self::exactly(4))
            ->method('get')
            ->willReturn($frame0, $frame1, $frame2, $frame2)
        ;

        $frameCollectionRevolver = $this->getTesteeInstance(
            frameCollection: $frameCollection,
        );

        self::assertInstanceOf(FrameCollectionRevolver::class, $frameCollectionRevolver);
        self::assertSame($frame0, $frameCollectionRevolver->update());
        self::assertSame($frame1, $frameCollectionRevolver->update());
        self::assertSame($frame2, $frameCollectionRevolver->update());
        self::assertSame($frame2, $frameCollectionRevolver->update(100000));
    }

    #[Test]
    public function canGetInterval(): void
    {
        $interval = $this->getIntervalMock();
        $interval
            ->expects(self::once())
            ->method('smallest')
            ->willReturnSelf()
        ;
        $frameCollectionRevolver = $this->getTesteeInstance(
            interval: $interval,
        );

        self::assertInstanceOf(FrameCollectionRevolver::class, $frameCollectionRevolver);
        self::assertSame($interval, $frameCollectionRevolver->getInterval());
    }

    #[Test]
    public function invokingCurrentInvokesGetOnCollection(): void
    {
        $frameCollection = $this->getOneElementFrameCollectionMock();
        $frameCollection
            ->expects(self::exactly(2))
            ->method('get')
        ;
        $frameCollectionRevolver = $this->getTesteeInstance(
            frameCollection: $frameCollection,
        );

        self::assertInstanceOf(FrameCollectionRevolver::class, $frameCollectionRevolver);
        self::callMethod($frameCollectionRevolver, 'current');
        self::callMethod($frameCollectionRevolver, 'current');
    }

    #[Test]
    public function throwsIfFrameCollectionIsEmpty(): void
    {
        $exceptionClass = InvalidArgumentException::class;
        $exceptionMessage = 'Frame collection is empty.';

        $test = function (): void {
            $frameCollectionRevolver = $this->getTesteeInstance(
                frameCollection: $this->getFrameCollectionMock(),
            );

            self::assertInstanceOf(FrameCollectionRevolver::class, $frameCollectionRevolver);
        };

        $this->wrapExceptionTest(
            test: $test,
            exceptionOrExceptionClass: $exceptionClass,
            exceptionMessage: $exceptionMessage,
        );
    }
}
