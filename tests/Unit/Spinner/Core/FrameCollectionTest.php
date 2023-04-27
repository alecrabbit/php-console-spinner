<?php

declare(strict_types=1);


namespace AlecRabbit\Tests\Unit\Spinner\Core;

use AlecRabbit\Spinner\Core\Contract\IFrameCollection;
use AlecRabbit\Spinner\Core\FrameCollection;
use AlecRabbit\Spinner\Exception\InvalidArgumentException;
use AlecRabbit\Tests\TestCase\TestCaseWithPrebuiltMocksAndStubs;
use ArrayObject;
use PHPUnit\Framework\Attributes\Test;
use Traversable;

final class FrameCollectionTest extends TestCaseWithPrebuiltMocksAndStubs
{
    #[Test]
    public function canBeCreated(): void
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

    protected function getTesteeInstance(Traversable $frames): IFrameCollection
    {
        return new FrameCollection($frames);
    }

    #[Test]
    public function canGetFrameByIndex(): void
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
            )
        );
        self::assertInstanceOf(FrameCollection::class, $frameCollection);
        self::assertSame($frame1, $frameCollection->get(1));
        self::assertSame($frame0, $frameCollection->get(0));
        self::assertSame($frame2, $frameCollection->get(2));
        self::assertSame($frame0, $frameCollection->get(0));
        self::assertSame(2, $frameCollection->lastIndex());
    }

    #[Test]
    public function throwsIfIsCreatedEmpty(): void
    {
        $exceptionClass = InvalidArgumentException::class;
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
        $exceptionClass = InvalidArgumentException::class;
        $exceptionMessage = '"AlecRabbit\Spinner\Contract\IFrame" expected, "string" given.';

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
