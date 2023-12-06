<?php

declare(strict_types=1);

namespace AlecRabbit\Tests\Spinner\Unit\Core\Revolver;

use AlecRabbit\Spinner\Contract\IFrame;
use AlecRabbit\Spinner\Contract\IInterval;
use AlecRabbit\Spinner\Core\Contract\IFrameCollection;
use AlecRabbit\Spinner\Core\Contract\ITolerance;
use AlecRabbit\Spinner\Core\Revolver\Contract\IFrameCollectionRevolver;
use AlecRabbit\Spinner\Core\Revolver\FrameCollectionRevolver;
use AlecRabbit\Spinner\Exception\InvalidArgument;
use AlecRabbit\Tests\TestCase\TestCase;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\MockObject\MockObject;

final class FrameCollectionRevolverTest extends TestCase
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

    protected function getOneElementFrameCollectionMock(): MockObject&IFrameCollection
    {
        $mockObject = $this->createMock(IFrameCollection::class);
        $mockObject->method('count')->willReturn(1);
        return $mockObject;
    }

    protected function getIntervalMock(): MockObject&IInterval
    {
        return $this->createMock(IInterval::class);
    }

    private function getToleranceMock(): MockObject&ITolerance
    {
        return $this->createMock(ITolerance::class);
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
//        $frameCollection
//            ->expects(self::once())
//            ->method('count')
//            ->willReturn(3)
//        ;

        $frame0 = $this->getFrameMock();
        $frame1 = $this->getFrameMock();
        $frame2 = $this->getFrameMock();

        {
            // A solution to absence of `->withConsecutive()` in PHPUnit 10
            $matcher = self::exactly(5);

            $frameCollection
                ->expects($matcher)
                ->method('current')
                ->willReturnCallback(
                    // FIXME (2023-12-05 14:59) [Alec Rabbit]: use ArrayObject as frame source
                    function () use ($matcher, $frame0, $frame1, $frame2) {
                        return match ($matcher->numberOfInvocations() % 3) {
                            1 => $frame0,
                            2 => $frame1,
                            0 => $frame2,
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
        self::assertSame($frame0, $frameCollectionRevolver->getFrame());
        self::assertSame($frame1, $frameCollectionRevolver->getFrame());
        self::assertSame($frame2, $frameCollectionRevolver->getFrame());
        self::assertSame($frame0, $frameCollectionRevolver->getFrame());
        self::assertSame($frame1, $frameCollectionRevolver->getFrame(1));
    }

    protected function getFrameCollectionMock(): MockObject&IFrameCollection
    {
        return $this->createMock(IFrameCollection::class);
    }

    protected function getFrameMock(): MockObject&IFrame
    {
        return $this->createMock(IFrame::class);
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
    public function invokingCurrentInvokesCurrentOnCollection(): void
    {
        $frameCollection = $this->getOneElementFrameCollectionMock();
        $frameCollection
            ->expects(self::exactly(2))
            ->method('current')
        ;
        $frameCollectionRevolver = $this->getTesteeInstance(
            frameCollection: $frameCollection,
        );

        self::assertInstanceOf(FrameCollectionRevolver::class, $frameCollectionRevolver);
        self::callMethod($frameCollectionRevolver, 'current');
        self::callMethod($frameCollectionRevolver, 'current');
    }

//    #[Test]
//    public function throwsIfFrameCollectionIsEmpty(): void
//    {
//        $exceptionClass = InvalidArgument::class;
//        $exceptionMessage = 'Frame collection is empty.';
//
//        $test = function (): void {
//            $frameCollectionRevolver = $this->getTesteeInstance(
//                frameCollection: $this->getFrameCollectionMock(),
//            );
//
//            self::assertInstanceOf(FrameCollectionRevolver::class, $frameCollectionRevolver);
//        };
//
//        $this->wrapExceptionTest(
//            test: $test,
//            exception: $exceptionClass,
//            message: $exceptionMessage,
//        );
//    }
}
