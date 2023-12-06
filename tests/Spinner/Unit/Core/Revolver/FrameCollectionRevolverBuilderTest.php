<?php

declare(strict_types=1);

namespace AlecRabbit\Tests\Spinner\Unit\Core\Revolver;

use AlecRabbit\Spinner\Contract\IInterval;
use AlecRabbit\Spinner\Core\Contract\IFrameCollection;
use AlecRabbit\Spinner\Core\Contract\ITolerance;
use AlecRabbit\Spinner\Core\Revolver\Contract\IFrameCollectionRevolverBuilder;
use AlecRabbit\Spinner\Core\Revolver\FrameCollectionRevolver;
use AlecRabbit\Spinner\Core\Revolver\FrameCollectionRevolverBuilder;
use AlecRabbit\Spinner\Exception\InvalidArgument;
use AlecRabbit\Spinner\Exception\LogicException;
use AlecRabbit\Tests\TestCase\TestCase;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\MockObject\MockObject;
use Traversable;

final class FrameCollectionRevolverBuilderTest extends TestCase
{
    #[Test]
    public function canBeInstantiated(): void
    {
        $frameRevolverBuilder = $this->getTesteeInstance();

        self::assertInstanceOf(FrameCollectionRevolverBuilder::class, $frameRevolverBuilder);
    }

    public function getTesteeInstance(): IFrameCollectionRevolverBuilder
    {
        return new FrameCollectionRevolverBuilder();
    }

    #[Test]
    public function canBuild(): void
    {
        $frameCollection = $this->getFrameCollectionMock();
//        $frameCollection
//            ->expects(self::once())
//            ->method('count')
//            ->willReturn(1)
//        ;

        $frameRevolverBuilder = $this->getTesteeInstance();
        $revolver =
            $frameRevolverBuilder
                ->withFrames($frameCollection)
                ->withInterval($this->getIntervalMock())
                ->withTolerance($this->getToleranceMock())
                ->build()
        ;

        self::assertInstanceOf(FrameCollectionRevolverBuilder::class, $frameRevolverBuilder);
        self::assertInstanceOf(FrameCollectionRevolver::class, $revolver);
    }

    protected function getFrameCollectionMock(): MockObject&IFrameCollection
    {
        return $this->createMock(IFrameCollection::class);
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
    public function throwsIfFrameCollectionIsNotSet(): void
    {
        $exceptionClass = LogicException::class;
        $exceptionMessage = 'Frame collection is not set.';

        $test = function (): void {
            $frameRevolverBuilder = $this->getTesteeInstance();

            $revolver =
                $frameRevolverBuilder
                    ->withInterval($this->getIntervalMock())
                    ->build()
            ;
            self::assertInstanceOf(FrameCollectionRevolverBuilder::class, $frameRevolverBuilder);
            self::assertInstanceOf(FrameCollectionRevolver::class, $revolver);
        };

        $this->wrapExceptionTest(
            test: $test,
            exception: $exceptionClass,
            message: $exceptionMessage,
        );
    }

    #[Test]
    public function throwsIfIntervalIsNotSet(): void
    {
        $exceptionClass = LogicException::class;
        $exceptionMessage = 'Interval is not set.';

        $test = function (): void {
            $frameRevolverBuilder = $this->getTesteeInstance();

            $revolver =
                $frameRevolverBuilder
                    ->withFrames($this->getFrameCollectionMock())
                    ->build()
            ;
            self::assertInstanceOf(FrameCollectionRevolverBuilder::class, $frameRevolverBuilder);
            self::assertInstanceOf(FrameCollectionRevolver::class, $revolver);
        };

        $this->wrapExceptionTest(
            test: $test,
            exception: $exceptionClass,
            message: $exceptionMessage,
        );
    }

    #[Test]
    public function throwsIfGeneratorPassedInsteadOfFrameCollection(): void
    {
        $exceptionClass = InvalidArgument::class;
        $exceptionMessage =
            'Frames must be instance of "AlecRabbit\Spinner\Core\Contract\IFrameCollection".';

        $test = function (): void {
            $frameRevolverBuilder = $this->getTesteeInstance();

            $revolver =
                $frameRevolverBuilder
                    ->withFrames($this->getTraversableMock())
                    ->withInterval($this->getIntervalMock())
                    ->build()
            ;
            self::assertInstanceOf(FrameCollectionRevolverBuilder::class, $frameRevolverBuilder);
            self::assertInstanceOf(FrameCollectionRevolver::class, $revolver);
        };

        $this->wrapExceptionTest(
            test: $test,
            exception: $exceptionClass,
            message: $exceptionMessage,
        );
    }


    private function getTraversableMock(): MockObject&Traversable
    {
        return $this->createMock(Traversable::class);
    }
}
