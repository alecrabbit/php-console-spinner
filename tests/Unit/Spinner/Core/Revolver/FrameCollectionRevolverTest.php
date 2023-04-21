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
