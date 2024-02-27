<?php

declare(strict_types=1);

namespace AlecRabbit\Tests\Spinner\Unit\Core\Driver;


use AlecRabbit\Spinner\Contract\IDeltaTimer;
use AlecRabbit\Spinner\Contract\ISequenceFrame;
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
        $renderer = $this->getTesteeInstance();

        self::assertInstanceOf(Renderer::class, $renderer);
    }

    private function getTesteeInstance(
        ?ISequenceStateWriter $stateWriter = null,
        ?IDeltaTimer $deltaTimer = null,
    ): IRenderer {
        return new Renderer(
            stateWriter: $stateWriter ?? $this->getSequenceStateWriterMock(),
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
            ->expects($this->once())
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
            ->expects($this->once())
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

        $stateWriter = $this->getSequenceStateWriterMock();
        $stateWriter
            ->expects($this->once())
            ->method('erase')
            ->with($this->identicalTo($sequenceState))
        ;

        $renderer = $this->getTesteeInstance(
            stateWriter: $stateWriter,
        );

        $spinner = $this->getSpinnerMock();
        $spinner
            ->expects($this->once())
            ->method('getState')
            ->willReturn($sequenceState)
        ;

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
        $sequenceState = $this->getSequenceStateMock();

        $spinner = $this->getSpinnerMock();
        $spinner
            ->expects($this->once())
            ->method('getState')
            ->with($this->equalTo(null))
            ->willReturn($sequenceState)
        ;

        $sequenceStateWriter = $this->getSequenceStateWriterMock();
        $sequenceStateWriter
            ->expects($this->once())
            ->method('write')
        ;

        $renderer =
            $this->getTesteeInstance(
                stateWriter: $sequenceStateWriter,
            );

        $renderer->initialize();

        $renderer->render($spinner);
    }

    #[Test]
    public function canRenderUsingTimer(): void
    {
        $delta = 0.1;
        $timer = $this->getDeltaTimerMock();
        $timer
            ->expects($this->once())
            ->method('getDelta')
            ->willReturn($delta)
        ;

        $spinner = $this->getSpinnerMock();
        $sequenceState = $this->getSequenceStateMock();
        $spinner
            ->expects($this->once())
            ->method('getState')
            ->with(self::identicalTo($delta))
            ->willReturn($sequenceState)
        ;

        $sequenceStateWriter = $this->getSequenceStateWriterMock();
        $sequenceStateWriter
            ->expects($this->once())
            ->method('write')
            ->with(self::identicalTo($sequenceState))
        ;

        $renderer =
            $this->getTesteeInstance(
                stateWriter: $sequenceStateWriter,
                deltaTimer: $timer
            );
        $renderer->initialize();

        $renderer->render($spinner);
    }

    private function getFrameMock(): MockObject&ISequenceFrame
    {
        return $this->createMock(ISequenceFrame::class);
    }
}
