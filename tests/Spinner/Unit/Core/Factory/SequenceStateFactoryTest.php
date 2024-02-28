<?php

declare(strict_types=1);

namespace AlecRabbit\Tests\Spinner\Unit\Core\Factory;

use AlecRabbit\Spinner\Contract\ISequenceFrame;
use AlecRabbit\Spinner\Core\Builder\Contract\ISequenceStateBuilder;
use AlecRabbit\Spinner\Core\CharSequenceFrame;
use AlecRabbit\Spinner\Core\Contract\ISequenceState;
use AlecRabbit\Spinner\Core\Factory\Contract\ISequenceStateFactory;
use AlecRabbit\Spinner\Core\Factory\SequenceStateFactory;
use AlecRabbit\Spinner\Core\SequenceState;
use AlecRabbit\Tests\TestCase\TestCase;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\MockObject\MockObject;

final class SequenceStateFactoryTest extends TestCase
{
    #[Test]
    public function canBeInstantiated(): void
    {
        $factory = $this->getTesteeInstance();

        self::assertInstanceOf(SequenceStateFactory::class, $factory);
    }

    public function getTesteeInstance(
        ?ISequenceStateBuilder $stateBuilder = null,
    ): ISequenceStateFactory {
        return
            new SequenceStateFactory(
                stateBuilder: $stateBuilder ?? $this->getStateBuilderMock(),
            );
    }

    private function getStateBuilderMock(): MockObject&ISequenceStateBuilder
    {
        return $this->createMock(ISequenceStateBuilder::class);
    }

    #[Test]
    public function canCreate(): void
    {
        $frame = $this->getSequenceFrameMock();
        $previousState = $this->getSequenceStateMock();
        $state = $this->getSequenceStateMock();

        $builder = $this->getStateBuilderMock();
        $builder
            ->expects(self::once())
            ->method('withSequenceFrame')
            ->with($frame)
            ->willReturn($builder)
        ;
        $builder
            ->expects(self::once())
            ->method('withPrevious')
            ->with($previousState)
            ->willReturn($builder)
        ;
        $builder
            ->expects(self::once())
            ->method('build')
            ->willReturn($state)
        ;

        $factory = $this->getTesteeInstance(
            stateBuilder: $builder,
        );

        $actual = $factory->create($frame, $previousState);
        self::assertSame($state, $actual);
    }

    private function getSequenceFrameMock(): MockObject&ISequenceFrame
    {
        return $this->createMock(ISequenceFrame::class);
    }

    private function getSequenceStateMock(): MockObject&ISequenceState
    {
        return $this->createMock(ISequenceState::class);
    }

    #[Test]
    public function canCreateEmpty(): void
    {
        $frame = new CharSequenceFrame('', 0);
        $previousState = new SequenceState('', 0, 0);
        $state = $this->getSequenceStateMock();

        $builder = $this->getStateBuilderMock();
        $builder
            ->expects(self::once())
            ->method('withSequenceFrame')
            ->with(self::equalTo($frame))
            ->willReturn($builder)
        ;
        $builder
            ->expects(self::once())
            ->method('withPrevious')
            ->with(self::equalTo($previousState))
            ->willReturn($builder)
        ;
        $builder
            ->expects(self::once())
            ->method('build')
            ->willReturn($state)
        ;

        $factory = $this->getTesteeInstance(
            stateBuilder: $builder,
        );

        $actual = $factory->create();
        self::assertSame($state, $actual);
    }

}
