<?php

declare(strict_types=1);

namespace AlecRabbit\Tests\Spinner\Unit\Core\Builder;

use AlecRabbit\Spinner\Contract\IObserver;
use AlecRabbit\Spinner\Contract\ISequenceState;
use AlecRabbit\Spinner\Core\Builder\Contract\ISpinnerBuilder;
use AlecRabbit\Spinner\Core\Builder\SpinnerBuilder;
use AlecRabbit\Spinner\Core\Factory\Contract\ISequenceStateFactory;
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
    public function canBuildWithoutState(): void
    {
        $builder = $this->getTesteeInstance();

        $widget = $this->getWidgetMock();
        $observer = $this->getObserverMock();
        $initialState = $this->getStateMock();
        $stateFactory = $this->getStateFactoryMock();
        $stateFactory
            ->expects(self::once())
            ->method('create')
            ->with(null, null)
            ->willReturn($initialState)
        ;

        $spinner = $builder
            ->withWidget($widget)
            ->withObserver($observer)
            ->withStateFactory($stateFactory)
            ->build()
        ;

        self::assertInstanceOf(Spinner::class, $spinner);
        self::assertSame($initialState, $spinner->getState());
    }

    private function getWidgetMock(): MockObject&IWidget
    {
        return $this->createMock(IWidget::class);
    }

    private function getObserverMock(): MockObject&IObserver
    {
        return $this->createMock(IObserver::class);
    }

    private function getStateMock(): MockObject&ISequenceState
    {
        return $this->createMock(ISequenceState::class);
    }

    private function getStateFactoryMock(): MockObject&ISequenceStateFactory
    {
        return $this->createMock(ISequenceStateFactory::class);
    }

    #[Test]
    public function canBuild(): void
    {
        $builder = $this->getTesteeInstance();

        $widget = $this->getWidgetMock();
        $observer = $this->getObserverMock();
        $initialState = $this->getStateMock();
        $stateFactory = $this->getStateFactoryMock();
        $stateFactory
            ->expects(self::never())
            ->method('create')
        ;

        $spinner = $builder
            ->withWidget($widget)
            ->withObserver($observer)
            ->withStateFactory($stateFactory)
            ->withInitialState($initialState)
            ->build()
        ;

        self::assertInstanceOf(Spinner::class, $spinner);
        self::assertSame($initialState, $spinner->getState());
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

    #[Test]
    public function throwsIfStateFactoryIsNotSet(): void
    {
        $builder = $this->getTesteeInstance();
        $widget = $this->getWidgetMock();
        $observer = $this->getObserverMock();

        $this->expectException(LogicException::class);
        $this->expectExceptionMessage('StateFactory is not set.');

        $builder
            ->withWidget($widget)
            ->withObserver($observer)
            ->build()
        ;
    }
}
