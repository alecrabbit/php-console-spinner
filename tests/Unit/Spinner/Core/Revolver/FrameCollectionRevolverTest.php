<?php

declare(strict_types=1);

namespace AlecRabbit\Tests\Unit\Spinner\Core\Revolver;

use AlecRabbit\Spinner\Contract\IInterval;
use AlecRabbit\Spinner\Core\Contract\IFrameCollection;
use AlecRabbit\Spinner\Core\Contract\ITolerance;
use AlecRabbit\Spinner\Core\Revolver\Contract\IFrameCollectionRevolver;
use AlecRabbit\Spinner\Core\Revolver\FrameCollectionRevolver;
use AlecRabbit\Spinner\Exception\InvalidArgumentException;
use AlecRabbit\Tests\TestCase\TestCaseWithPrebuiltMocksAndStubs;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\MockObject\MockObject;

final class FrameCollectionRevolverTest extends TestCaseWithPrebuiltMocksAndStubs
{
    #[Test]
    public function canBeInstantiated(): void
    {
        $frameCollectionRevolver = $this->getTesteeInstance();

        self::assertInstanceOf(FrameCollectionRevolver::class, $frameCollectionRevolver);
    }

    public function getTesteeInstance(
        ?IFrameCollection $frameCollection = null,
        ?IInterval $interval = null,
        ?ITolerance $tolerance = null,
    ): IFrameCollectionRevolver {
        return
            new FrameCollectionRevolver(
                frameCollection: $frameCollection ?? $this->getOneElementFrameCollectionMock(),
                interval: $interval ?? $this->getIntervalMock(),
                tolerance: $tolerance ?? $this->getToleranceMock(),
            );
    }

    private function getToleranceMock(): MockObject&ITolerance
    {
        return $this->createMock(ITolerance::class);
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
        $interval = $this->getIntervalMock();

        $interval
            ->expects(self::once())
            ->method('toMilliseconds')
            ->willReturn(10.0)
        ;

        $frameCollection = $this->getFrameCollectionMock();
        $frameCollection
            ->expects(self::once())
            ->method('count')
            ->willReturn(3)
        ;

        $frame0 = $this->getFrameMock();
        $frame1 = $this->getFrameMock();
        $frame2 = $this->getFrameMock();

        {
            // A solution to absence of `->withConsecutive()` in PHPUnit 10
            $matcher = self::exactly(4);

            $frameCollection
                ->expects($matcher)
                ->method('get')
                ->willReturnCallback(
                    function (int $offset) use ($matcher, $frame0, $frame1, $frame2) {
                        match ($matcher->numberOfInvocations()) {
                            1 => self::assertEquals(1, $offset),
                            2 => self::assertEquals(2, $offset),
                            3, 4 => self::assertEquals(0, $offset),
                        };

                        return
                            match ($offset) {
                                0 => $frame0,
                                1 => $frame1,
                                2 => $frame2,
                            };
                    }
                )
            ;
        }

        $frameCollectionRevolver = $this->getTesteeInstance(
            frameCollection: $frameCollection,
            interval: $interval,
        );

        self::assertInstanceOf(FrameCollectionRevolver::class, $frameCollectionRevolver);
        self::assertSame($frame1, $frameCollectionRevolver->getFrame());
        self::assertSame($frame2, $frameCollectionRevolver->getFrame());
        self::assertSame($frame0, $frameCollectionRevolver->getFrame());
        self::assertSame($frame0, $frameCollectionRevolver->getFrame(1));
    }

    #[Test]
    public function canGetInterval(): void
    {
        $interval = $this->getIntervalMock();

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
            exception: $exceptionClass,
            message: $exceptionMessage,
        );
    }
}
