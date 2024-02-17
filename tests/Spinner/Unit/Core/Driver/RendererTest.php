<?php

declare(strict_types=1);

namespace AlecRabbit\Tests\Spinner\Unit\Core\Driver;


use AlecRabbit\Spinner\Contract\IDeltaTimer;
use AlecRabbit\Spinner\Contract\ISequenceFrame;
use AlecRabbit\Spinner\Core\Builder\Contract\ISequenceStateBuilder;
use AlecRabbit\Spinner\Core\Contract\IRenderer;
use AlecRabbit\Spinner\Core\Contract\ISequenceState;
use AlecRabbit\Spinner\Core\Contract\ISpinner;
use AlecRabbit\Spinner\Core\Driver\Renderer;
use AlecRabbit\Spinner\Core\Output\Contract\ISequenceStateWriter;
use AlecRabbit\Tests\TestCase\TestCase;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\MockObject\MockObject;

final class RendererTest extends TestCase
{
    #[Test]
    public function canBeInstantiated(): void
    {
        $stateBuilder = $this->getSequenceStateBuilderMock();
        $stateBuilder
            ->expects(self::once())
            ->method('withSequence')
            ->with(self::identicalTo(''))
            ->willReturnSelf()
        ;
        $stateBuilder
            ->expects(self::once())
            ->method('withWidth')
            ->with(self::identicalTo(0))
            ->willReturnSelf()
        ;
        $stateBuilder
            ->expects(self::once())
            ->method('withPreviousWidth')
            ->with(self::identicalTo(0))
            ->willReturnSelf()
        ;
        $stateBuilder
            ->expects(self::once())
            ->method('build')
        ;

        $renderer = $this->getTesteeInstance(
            stateBuilder: $stateBuilder,
        );

        self::assertInstanceOf(Renderer::class, $renderer);
    }

    private function getSequenceStateBuilderMock(): MockObject&ISequenceStateBuilder
    {
        return $this->createMock(ISequenceStateBuilder::class);
    }

    private function getTesteeInstance(
        ?ISequenceStateWriter $stateWriter = null,
        ?ISequenceStateBuilder $stateBuilder = null,
        ?IDeltaTimer $deltaTimer = null,
    ): IRenderer {
        return new Renderer(
            stateWriter: $stateWriter ?? $this->getSequenceStateWriterMock(),
            stateBuilder: $stateBuilder ?? $this->getSequenceStateBuilderMock(),
            deltaTimer: $deltaTimer ?? $this->getDeltaTimerMock(),
        );
    }

    private function getSequenceStateWriterMock(): MockObject&ISequenceStateWriter
    {
        return $this->createMock(ISequenceStateWriter::class);
    }

    private function getDeltaTimerMock(): MockObject&IDeltaTimer
    {
        return $this->createMock(IDeltaTimer::class);
    }

    #[Test]
    public function canInitialize(): void
    {
        $sequenceStateWriter = $this->getSequenceStateWriterMock();
        $sequenceStateWriter
            ->expects(self::once())
            ->method('initialize')
        ;

        $renderer = $this->getTesteeInstance(
            stateWriter: $sequenceStateWriter
        );

        $renderer->initialize();
    }

    #[Test]
    public function canFinalize(): void
    {
        $message = 'message';
        $sequenceStateWriter = $this->getSequenceStateWriterMock();
        $sequenceStateWriter
            ->expects(self::once())
            ->method('finalize')
            ->with(self::identicalTo($message))
        ;

        $renderer = $this->getTesteeInstance(
            stateWriter: $sequenceStateWriter
        );

        $renderer->finalize($message);
    }

    #[Test]
    public function canErase(): void
    {
        $sequenceState = $this->getSequenceStateMock();

        $stateBuilder = $this->getSequenceStateBuilderMock();
        $stateBuilder
            ->expects(self::once())
            ->method('withSequence')
            ->with(self::identicalTo(''))
            ->willReturnSelf()
        ;
        $stateBuilder
            ->expects(self::once())
            ->method('withWidth')
            ->with(self::identicalTo(0))
            ->willReturnSelf()
        ;
        $stateBuilder
            ->expects(self::once())
            ->method('withPreviousWidth')
            ->with(self::identicalTo(0))
            ->willReturnSelf()
        ;
        $stateBuilder
            ->expects(self::once())
            ->method('build')
            ->willReturn($sequenceState)
        ;

        $stateWriter = $this->getSequenceStateWriterMock();
        $stateWriter
            ->expects(self::once())
            ->method('erase')
            ->with(self::identicalTo($sequenceState))
        ;

        $renderer = $this->getTesteeInstance(
            stateWriter: $stateWriter,
            stateBuilder: $stateBuilder,
        );

        $spinner = $this->getSpinnerMock();
        $renderer->erase($spinner);
    }

    private function getSequenceStateMock(): MockObject&ISequenceState
    {
        return $this->createMock(ISequenceState::class);
    }

    private function getSpinnerMock(): MockObject&ISpinner
    {
        return $this->createMock(ISpinner::class);
    }

    #[Test]
    public function canRender(): void
    {
        $sequence = 'sequence';
        $width = 8;

        $frame = $this->getFrameMock();
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

        $spinner = $this->getSpinnerMock();
        $spinner
            ->expects(self::once())
            ->method('getFrame')
            ->with(self::equalTo(null))
            ->willReturn($frame)
        ;

        $sequenceStateWriter = $this->getSequenceStateWriterMock();
        $sequenceStateWriter
            ->expects(self::once())
            ->method('write')
        ;

        $renderer =
            $this->getTesteeInstance(
                stateWriter: $sequenceStateWriter,
            );
        $renderer->initialize();

        $renderer->render($spinner);
    }

    private function getFrameMock(): MockObject&ISequenceFrame
    {
        return $this->createMock(ISequenceFrame::class);
    }

    #[Test]
    public function canRenderUsingTimer(): void
    {
        $delta = 0.1;
        $timer = $this->getDeltaTimerMock();
        $timer
            ->expects(self::once())
            ->method('getDelta')
            ->willReturn($delta)
        ;

        $spinner = $this->getSpinnerMock();
        $spinner
            ->expects(self::once())
            ->method('getFrame')
            ->with(self::identicalTo($delta))
        ;

        $sequenceStateWriter = $this->getSequenceStateWriterMock();
        $sequenceStateWriter
            ->expects(self::once())
            ->method('write')
        ;

        $sequenceStateBuilder = $this->getSequenceStateBuilderMock();
        $sequenceStateBuilder
            ->expects(self::exactly(2))
            ->method('withSequence')
            ->willReturnSelf()
        ;
        $sequenceStateBuilder
            ->expects(self::exactly(2))
            ->method('withWidth')
            ->willReturnSelf()
        ;
        $sequenceStateBuilder
            ->expects(self::exactly(2))
            ->method('withPreviousWidth')
            ->willReturnSelf()
        ;
        $sequenceStateBuilder
            ->expects(self::exactly(2))
            ->method('build')
        ;

        $renderer =
            $this->getTesteeInstance(
                stateWriter: $sequenceStateWriter,
                stateBuilder: $sequenceStateBuilder,
                deltaTimer: $timer
            );
        $renderer->initialize();

        $renderer->render($spinner);
    }
}
