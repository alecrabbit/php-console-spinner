<?php

declare(strict_types=1);

namespace AlecRabbit\Tests\Unit\Spinner\Core\Widget;

use AlecRabbit\Spinner\Core\Widget\Contract\IWidgetContextContainer;
use AlecRabbit\Spinner\Core\Widget\Contract\IWidgetIntervalContainer;
use AlecRabbit\Spinner\Core\Widget\WidgetContextContainer;
use AlecRabbit\Spinner\Core\Widget\WidgetIntervalContainer;
use AlecRabbit\Spinner\Exception\InvalidArgumentException;
use AlecRabbit\Tests\TestCase\TestCaseWithPrebuiltMocksAndStubs;
use PHPUnit\Framework\Attributes\Test;
use WeakMap;

final class WidgetIntervalContainerTest extends TestCaseWithPrebuiltMocksAndStubs
{
    #[Test]
    public function canBeCreated(): void
    {
        $intervalContainer = $this->getTesteeInstance();

        self::assertInstanceOf(WidgetIntervalContainer::class, $intervalContainer);
    }

    public function getTesteeInstance(): IWidgetIntervalContainer
    {
        return new WidgetIntervalContainer();
    }

    #[Test]
    public function returnsNullForSmallestIfEmpty(): void
    {
        $intervalContainer = $this->getTesteeInstance();

        self::assertInstanceOf(WidgetIntervalContainer::class, $intervalContainer);
        self::assertNull($intervalContainer->getSmallest());
    }

    #[Test]
    public function canAddInterval(): void
    {
        $interval = $this->getIntervalMock();
        $intervalContainer = $this->getTesteeInstance();

        $intervalContainer->add($interval);

        self::assertSame($interval, $intervalContainer->getSmallest());
    }

    #[Test]
    public function canRemoveOneIntervalAddedBefore(): void
    {
        $interval = $this->getIntervalMock();
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
