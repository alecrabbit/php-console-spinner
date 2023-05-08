<?php

declare(strict_types=1);

namespace AlecRabbit\Tests\Unit\Spinner\Core\Revolver;

use AlecRabbit\Spinner\Core\Revolver\Contract\IFrameRevolverBuilder;
use AlecRabbit\Spinner\Core\Revolver\FrameCollectionRevolver;
use AlecRabbit\Spinner\Core\Revolver\FrameRevolverBuilder;
use AlecRabbit\Spinner\Exception\LogicException;
use AlecRabbit\Tests\TestCase\TestCaseWithPrebuiltMocksAndStubs;
use PHPUnit\Framework\Attributes\Test;

final class FrameRevolverBuilderTest extends TestCaseWithPrebuiltMocksAndStubs
{
    #[Test]
    public function canBeCreated(): void
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
                ->withTolerance(10)
                ->build()
        ;

        self::assertInstanceOf(FrameRevolverBuilder::class, $frameRevolverBuilder);
        self::assertInstanceOf(FrameCollectionRevolver::class, $revolver);
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
