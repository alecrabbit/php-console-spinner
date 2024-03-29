<?php

declare(strict_types=1);

namespace AlecRabbit\Tests\Spinner\Unit\Core\Revolver;

use AlecRabbit\Spinner\Contract\IInterval;
use AlecRabbit\Spinner\Core\Contract\IFrameCollection;
use AlecRabbit\Spinner\Core\Contract\ITolerance;
use AlecRabbit\Spinner\Core\Revolver\Contract\IFrameRevolverBuilder;
use AlecRabbit\Spinner\Core\Revolver\FrameCollectionRevolver;
use AlecRabbit\Spinner\Core\Revolver\FrameRevolverBuilder;
use AlecRabbit\Spinner\Exception\LogicException;
use AlecRabbit\Tests\TestCase\TestCase;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\MockObject\MockObject;

final class FrameRevolverBuilderTest extends TestCase
{
    #[Test]
    public function canBeInstantiated(): void
    {
        $frameRevolverBuilder = $this->getTesteeInstance();

        self::assertInstanceOf(FrameRevolverBuilder::class, $frameRevolverBuilder);
    }

    public function getTesteeInstance(): IFrameRevolverBuilder
    {
        return new FrameRevolverBuilder();
    }

    #[Test]
    public function canBuild(): void
    {
        $frameCollection = $this->getFrameCollectionMock();
        $frameCollection
            ->expects(self::once())
            ->method('count')
            ->willReturn(1)
        ;

        $frameRevolverBuilder = $this->getTesteeInstance();
        $revolver =
            $frameRevolverBuilder
                ->withFrameCollection($frameCollection)
                ->withInterval($this->getIntervalMock())
                ->withTolerance($this->getToleranceMock())
                ->build()
        ;

        self::assertInstanceOf(FrameRevolverBuilder::class, $frameRevolverBuilder);
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
            self::assertInstanceOf(FrameRevolverBuilder::class, $frameRevolverBuilder);
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
                    ->withFrameCollection($this->getFrameCollectionMock())
                    ->build()
            ;
            self::assertInstanceOf(FrameRevolverBuilder::class, $frameRevolverBuilder);
            self::assertInstanceOf(FrameCollectionRevolver::class, $revolver);
        };

        $this->wrapExceptionTest(
            test: $test,
            exception: $exceptionClass,
            message: $exceptionMessage,
        );
    }

}
