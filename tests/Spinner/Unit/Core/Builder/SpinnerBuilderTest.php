<?php

declare(strict_types=1);

namespace AlecRabbit\Tests\Spinner\Unit\Core\Builder;

use AlecRabbit\Spinner\Contract\IObserver;
use AlecRabbit\Spinner\Core\Builder\Contract\ISpinnerBuilder;
use AlecRabbit\Spinner\Core\Builder\SpinnerBuilder;
use AlecRabbit\Spinner\Core\Spinner;
use AlecRabbit\Spinner\Core\Widget\Contract\IWidget;
use AlecRabbit\Spinner\Exception\LogicException;
use AlecRabbit\Tests\TestCase\TestCase;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\MockObject\MockObject;

final class SpinnerBuilderTest extends TestCase
{
    #[Test]
    public function canBeInstantiated(): void
    {
        $builder = $this->getTesteeInstance();

        self::assertInstanceOf(SpinnerBuilder::class, $builder);
    }

    public function getTesteeInstance(): ISpinnerBuilder
    {
        return new SpinnerBuilder();
    }

    #[Test]
    public function canBuild(): void
    {
        $builder = $this->getTesteeInstance();

        $widget = $this->getWidgetMock();
        $observer = $this->getObserverMock();

        $spinner = $builder
            ->withWidget($widget)
            ->withObserver($observer)
            ->build()
        ;

        self::assertInstanceOf(Spinner::class, $spinner);
    }

    private function getWidgetMock(): MockObject&IWidget
    {
        return $this->createMock(IWidget::class);
    }

    private function getObserverMock(): MockObject&IObserver
    {
        return $this->createMock(IObserver::class);
    }

    #[Test]
    public function throwsIfWidgetIsNotSet(): void
    {
        $builder = $this->getTesteeInstance();

        $this->expectException(LogicException::class);
        $this->expectExceptionMessage('Widget is not set.');

        $builder
            ->build()
        ;
    }
}
