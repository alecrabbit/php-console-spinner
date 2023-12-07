<?php

declare(strict_types=1);

namespace AlecRabbit\Tests\Spinner\Unit\Core;

use AlecRabbit\Spinner\Contract\IFrame;
use AlecRabbit\Spinner\Core\Contract\IFrameCollection;
use AlecRabbit\Spinner\Core\FrameCollection;
use AlecRabbit\Spinner\Exception\InvalidArgument;
use AlecRabbit\Tests\TestCase\TestCase;
use ArrayObject;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\MockObject\MockObject;
use Traversable;

final class FrameCollectionTest extends TestCase
{
    #[Test]
    public function canBeInstantiated(): void
    {
        $frameCollection = $this->getTesteeInstance(
            new ArrayObject(
                [
                    $this->getFrameMock(),
                    $this->getFrameMock(),
                    $this->getFrameMock(),
                ]
            )
        );
        self::assertInstanceOf(FrameCollection::class, $frameCollection);
    }

    protected function getTesteeInstance(
        Traversable $frames,
        int $index = 0,
    ): IFrameCollection {
        return new FrameCollection(
            frames: $frames,
            index: $index,
        );
    }

    protected function getFrameMock(): MockObject&IFrame
    {
        return $this->createMock(IFrame::class);
    }

    #[Test]
    public function canGetCurrentInCombinationWithNext(): void
    {
        $frame0 = $this->getFrameMock();
        $frame1 = $this->getFrameMock();
        $frame2 = $this->getFrameMock();
        $frameCollection = $this->getTesteeInstance(
            new ArrayObject(
                [
                    $frame0,
                    $frame1,
                    $frame2,
                ]
            ),
        );
        self::assertInstanceOf(FrameCollection::class, $frameCollection);

        self::assertSame($frame0, $frameCollection->current());
        $frameCollection->next();
        self::assertSame($frame1, $frameCollection->current());
        $frameCollection->next();
        self::assertSame($frame2, $frameCollection->current());
        $frameCollection->next();
        self::assertSame($frame0, $frameCollection->current());
    }

    #[Test]
    public function throwsIfIsCreatedEmpty(): void
    {
        $exceptionClass = InvalidArgument::class;
        $exceptionMessage = 'Collection is empty.';

        $test = function (): void {
            $frameCollection = $this->getTesteeInstance(new ArrayObject([]));
            self::assertInstanceOf(FrameCollection::class, $frameCollection);
        };

        $this->wrapExceptionTest(
            test: $test,
            exception: $exceptionClass,
            message: $exceptionMessage,
        );
    }

    #[Test]
    public function throwsIfIsCreatedWithWrongTypeTraversable(): void
    {
        $exceptionClass = InvalidArgument::class;
        $exceptionMessage =
            'Frame should be an instance of "AlecRabbit\Spinner\Contract\IFrame". "string" given.';

        $test = function (): void {
            $frameCollection = $this->getTesteeInstance(new ArrayObject(['a string']));
            self::assertInstanceOf(FrameCollection::class, $frameCollection);
        };

        $this->wrapExceptionTest(
            test: $test,
            exception: $exceptionClass,
            message: $exceptionMessage,
        );
    }
}
