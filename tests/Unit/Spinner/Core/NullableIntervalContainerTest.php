<?php

declare(strict_types=1);

namespace AlecRabbit\Tests\Unit\Spinner\Core;

use AlecRabbit\Spinner\Contract\IObserver;
use AlecRabbit\Spinner\Core\Contract\INullableIntervalContainer;
use AlecRabbit\Spinner\Core\NullableIntervalContainer;
use AlecRabbit\Tests\TestCase\TestCaseWithPrebuiltMocksAndStubs;
use PHPUnit\Framework\Attributes\Test;
use WeakMap;

final class NullableIntervalContainerTest extends TestCaseWithPrebuiltMocksAndStubs
{
    #[Test]
    public function canBeCreated(): void
    {
        $intervalContainer = $this->getTesteeInstance();

        self::assertInstanceOf(NullableIntervalContainer::class, $intervalContainer);
    }

    public function getTesteeInstance(
        ?WeakMap $map = null,
        ?IObserver $observer = null,
    ): INullableIntervalContainer {
        return new NullableIntervalContainer(
            map: $map ?? new WeakMap(),
            observer: $observer,
        );
    }

    #[Test]
    public function returnsNullForSmallestIfEmpty(): void
    {
        $intervalContainer = $this->getTesteeInstance();

        self::assertInstanceOf(NullableIntervalContainer::class, $intervalContainer);
        self::assertNull($intervalContainer->getSmallest());
    }

    #[Test]
    public function canAddInterval(): void
    {
        $interval = $this->getIntervalMock();
        $interval
            ->expects(self::once())
            ->method('smallest')
            ->willReturnSelf()
        ;

        $intervalContainer = $this->getTesteeInstance();

        $intervalContainer->add($interval);

        self::assertSame($interval, $intervalContainer->getSmallest());
    }

    #[Test]
    public function canRemoveOneIntervalAddedBefore(): void
    {
        $interval = $this->getIntervalMock();
        $interval
            ->expects(self::once())
            ->method('smallest')
            ->willReturnSelf()
        ;

        $intervalContainer = $this->getTesteeInstance();

        $intervalContainer->add($interval);

        self::assertSame($interval, $intervalContainer->getSmallest());

        $intervalContainer->remove($interval);

        self::assertNull($intervalContainer->getSmallest());
    }

    #[Test]
    public function removingNonExistingIntervalDoesNotThrow(): void
    {
        $interval = $this->getIntervalMock();
        $intervalContainer = $this->getTesteeInstance();

        $intervalContainer->remove($interval);

        self::assertNull($intervalContainer->getSmallest());
    }
}
