<?php

declare(strict_types=1);

namespace AlecRabbit\Tests\Unit\Spinner\Core\Widget;

use AlecRabbit\Spinner\Contract\IObserver;
use AlecRabbit\Spinner\Contract\ISubject;
use AlecRabbit\Spinner\Core\Widget\Contract\IWidgetCompositeChildrenContainer;
use AlecRabbit\Spinner\Core\Widget\WidgetCompositeChildrenContainer;
use AlecRabbit\Tests\TestCase\TestCaseWithPrebuiltMocksAndStubs;
use PHPUnit\Framework\Attributes\Test;

final class WidgetCompositeChildrenContainerTest extends TestCaseWithPrebuiltMocksAndStubs
{
    #[Test]
    public function canBeCreated(): void
    {
        $container = $this->getTesteeInstance();

        self::assertInstanceOf(WidgetCompositeChildrenContainer::class, $container);
    }      #[Test]
    public function canBeObserver(): void
    {
        $container = $this->getTesteeInstance();

        self::assertInstanceOf(IObserver::class, $container);
    }
    #[Test]
    public function canBeASubject(): void
    {
        $container = $this->getTesteeInstance();

        self::assertInstanceOf(ISubject::class, $container);
    }

    public function getTesteeInstance(): IWidgetCompositeChildrenContainer
    {
        return new WidgetCompositeChildrenContainer();
    }
}
