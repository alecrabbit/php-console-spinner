<?php

declare(strict_types=1);

namespace AlecRabbit\Tests\Spinner\Unit\Core\Builder;

use AlecRabbit\Spinner\Contract\ISequenceFrame;
use AlecRabbit\Spinner\Core\Builder\Contract\ISequenceStateBuilder;
use AlecRabbit\Spinner\Core\Builder\SequenceStateBuilder;
use AlecRabbit\Spinner\Core\Contract\ISequenceState;
use AlecRabbit\Spinner\Core\SequenceState;
use AlecRabbit\Spinner\Exception\LogicException;
use AlecRabbit\Tests\TestCase\TestCase;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\MockObject\MockObject;

final class SequenceStateBuilderTest extends TestCase
{
    #[Test]
    public function canBeInstantiated(): void
    {
        $builder = $this->getTesteeInstance();

        self::assertInstanceOf(SequenceStateBuilder::class, $builder);
    }

    public function getTesteeInstance(): ISequenceStateBuilder
    {
        return new SequenceStateBuilder();
    }

    #[Test]
    public function canBuild(): void
    {
        $sequence = self::getFaker()->word();
        $width = self::getFaker()->numberBetween(1, 10);
        $previousWidth = self::getFaker()->numberBetween(1, 10);

        $frame = $this->getSequenceFrameMock();
        $frame
            ->expects(self::once())
            ->method('getSequence')
            ->willReturn($sequence)
        ;
        $frame
            ->expects(self::once())
            ->method('getWidth')
            ->willReturn($width)
        ;

        $previousState = $this->getSequenceStateMock();
        $previousState
            ->expects(self::once())
            ->method('getWidth')
            ->willReturn($previousWidth)
        ;

        $builder = $this->getTesteeInstance();

        $state =
            $builder
                ->withSequenceFrame($frame)
                ->withPrevious($previousState)
                ->build()
        ;

        self::assertInstanceOf(SequenceState::class, $state);
        self::assertEquals($sequence, $state->getSequence());
        self::assertEquals($width, $state->getWidth());
        self::assertEquals($previousWidth, $state->getPreviousWidth());
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
    public function throwIfSequenceIsNotSet(): void
    {
        $width = self::getFaker()->numberBetween(1, 10);
        $previousWidth = self::getFaker()->numberBetween(1, 10);

        $this->expectException(LogicException::class);
        $this->expectExceptionMessage('Sequence is not set.');

        $this->getTesteeInstance()
            ->withWidth($width)
            ->withPreviousWidth($previousWidth)
            ->build()
        ;

        self::fail('Exception was not thrown.');
    }

    #[Test]
    public function throwIfWidthIsNotSet(): void
    {
        $sequence = self::getFaker()->word();
        $previousWidth = self::getFaker()->numberBetween(1, 10);

        $this->expectException(LogicException::class);
        $this->expectExceptionMessage('Width is not set.');

        $this->getTesteeInstance()
            ->withSequence($sequence)
            ->withPreviousWidth($previousWidth)
            ->build()
        ;

        self::fail('Exception was not thrown.');
    }

    #[Test]
    public function throwIfPreviousWidthIsNotSet(): void
    {
        $sequence = self::getFaker()->word();
        $width = self::getFaker()->numberBetween(1, 10);

        $this->expectException(LogicException::class);
        $this->expectExceptionMessage('Previous width is not set.');

        $this->getTesteeInstance()
            ->withSequence($sequence)
            ->withWidth($width)
            ->build()
        ;

        self::fail('Exception was not thrown.');
    }
}
