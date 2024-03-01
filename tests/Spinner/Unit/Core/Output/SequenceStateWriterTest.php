<?php

declare(strict_types=1);

namespace AlecRabbit\Tests\Spinner\Unit\Core\Output;

use AlecRabbit\Spinner\Contract\ISequenceState;
use AlecRabbit\Spinner\Contract\Output\IBufferedOutput;
use AlecRabbit\Spinner\Core\Feature\Resolver\Contract\IInitializationResolver;
use AlecRabbit\Spinner\Core\Output\Contract\IConsoleCursor;
use AlecRabbit\Spinner\Core\Output\Contract\ISequenceStateWriter;
use AlecRabbit\Spinner\Core\Output\SequenceStateWriter;
use AlecRabbit\Tests\TestCase\TestCase;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\MockObject\Stub;

final class SequenceStateWriterTest extends TestCase
{
    #[Test]
    public function createdUninitialized(): void
    {
        $sequenceStateWriter = $this->getTesteeInstance();

        self::assertInstanceOf(SequenceStateWriter::class, $sequenceStateWriter);
        self::assertFalse(self::getPropertyValue('initialized', $sequenceStateWriter));
    }

    public function getTesteeInstance(
        ?IBufferedOutput $output = null,
        ?IConsoleCursor $cursor = null,
        ?IInitializationResolver $initializationResolver = null,
    ): ISequenceStateWriter {
        return
            new SequenceStateWriter(
                output: $output ?? $this->getBufferedOutputMock(),
                cursor: $cursor ?? $this->getCursorMock(),
                initializationResolver: $initializationResolver ?? $this->getInitializationResolverMock(),
            );
    }

    protected function getBufferedOutputMock(): MockObject&IBufferedOutput
    {
        return $this->createMock(IBufferedOutput::class);
    }

    protected function getCursorMock(): MockObject&IConsoleCursor
    {
        return $this->createMock(IConsoleCursor::class);
    }

    private function getInitializationResolverMock(): MockObject&IInitializationResolver
    {
        return $this->createMock(IInitializationResolver::class);
    }

    #[Test]
    public function canBeFinalizedIfInitialized(): void
    {
        $initializationResolver = $this->getInitializationResolverMock();
        $initializationResolver
            ->expects(self::once())
            ->method('isEnabled')
            ->willReturn(true)
        ;

        $cursor = $this->getCursorMock();
        $cursor->expects(self::once())->method('hide');
        $cursor->expects(self::once())->method('show');

        $output = $this->getBufferedOutputMock();

        $message = 'final message';

        $output->expects(self::once())->method('append')->with($message);
        $output->expects(self::exactly(2))->method('flush');

        $sequenceStateWriter = $this->getTesteeInstance(
            output: $output,
            cursor: $cursor,
            initializationResolver: $initializationResolver,
        );

        $sequenceStateWriter->initialize();
        $sequenceStateWriter->finalize($message);

        self::assertFalse(self::getPropertyValue('initialized', $sequenceStateWriter));
    }

    #[Test]
    public function canBeFinalizedIfInitializedWithEmptyMessage(): void
    {
        $initializationResolver = $this->getInitializationResolverMock();
        $initializationResolver
            ->expects(self::once())
            ->method('isEnabled')
            ->willReturn(true)
        ;

        $cursor = $this->getCursorMock();
        $cursor->expects(self::once())->method('hide');
        $cursor->expects(self::once())->method('show');

        $output = $this->getBufferedOutputMock();

        $message = '';

        $output->expects(self::never())->method('append')->with($message);
        $output->expects(self::exactly(2))->method('flush');

        $sequenceStateWriter = $this->getTesteeInstance(
            output: $output,
            cursor: $cursor,
            initializationResolver: $initializationResolver,
        );

        $sequenceStateWriter->initialize();
        $sequenceStateWriter->finalize($message);

        self::assertFalse(self::getPropertyValue('initialized', $sequenceStateWriter));
    }

    #[Test]
    public function canBeFinalizedIfInitializedWithNoMessage(): void
    {
        $initializationResolver = $this->getInitializationResolverMock();
        $initializationResolver
            ->expects(self::once())
            ->method('isEnabled')
            ->willReturn(true)
        ;

        $cursor = $this->getCursorMock();
        $cursor->expects(self::once())->method('hide');
        $cursor->expects(self::once())->method('show');

        $output = $this->getBufferedOutputMock();

        $message = null;

        $output->expects(self::never())->method('append')->with($message);
        $output->expects(self::exactly(2))->method('flush');

        $sequenceStateWriter = $this->getTesteeInstance(
            output: $output,
            cursor: $cursor,
            initializationResolver: $initializationResolver,
        );

        $sequenceStateWriter->initialize();
        self::assertTrue(self::getPropertyValue('initialized', $sequenceStateWriter));
        $sequenceStateWriter->finalize($message);
    }

    #[Test]
    public function canEraseIfInitialized(): void
    {
        $initializationResolver = $this->getInitializationResolverMock();
        $initializationResolver
            ->expects(self::once())
            ->method('isEnabled')
            ->willReturn(true)
        ;

        $cursor = $this->getCursorMock();
        $cursor->expects(self::once())->method('erase')->willReturnSelf();

        $sequenceStateWriter = $this->getTesteeInstance(
            cursor: $cursor,
            initializationResolver: $initializationResolver,
        );

        $sequenceStateWriter->initialize();
        $sequenceStateWriter->erase($this->getSpinnerStateStub());
    }

    protected function getSpinnerStateStub(): Stub&ISequenceState
    {
        return $this->createStub(ISequenceState::class);
    }

    #[Test]
    public function canNotEraseIfUninitialized(): void
    {
        $cursor = $this->getCursorMock();
        $cursor
            ->expects(self::never())
            ->method('erase')
            ->willReturnSelf()
        ;

        $sequenceStateWriter = $this->getTesteeInstance(cursor: $cursor);

        $sequenceStateWriter->erase($this->getSpinnerStateStub());
    }

    #[Test]
    public function canNotBeFinalizedIfUninitialized(): void
    {
        $cursor = $this->getCursorMock();
        $cursor->expects(self::never())->method('hide');
        $cursor->expects(self::never())->method('show');

        $output = $this->getBufferedOutputMock();

        $message = 'final message';

        $output->expects(self::never())->method('append')->with($message);
        $output->expects(self::never())->method('flush');

        $sequenceStateWriter = $this->getTesteeInstance($output, $cursor);

        $sequenceStateWriter->finalize($message);
    }

    #[Test]
    public function canNotWriteIfUninitialized(): void
    {
        $cursor = $this->getCursorMock();
        $cursor->expects(self::never())->method('erase')->willReturnSelf();
        $cursor->expects(self::never())->method('moveLeft')->willReturnSelf();

        $output = $this->getBufferedOutputMock();

        $output->expects(self::never())->method('append');
        $output->expects(self::never())->method('flush');

        $sequenceStateWriter = $this->getTesteeInstance($output, $cursor);

        $spinnerState = $this->getSpinnerStateMock();
        $spinnerState->expects(self::never())->method('getSequence');
        $spinnerState->expects(self::never())->method('getWidth');
        $spinnerState->expects(self::never())->method('getPreviousWidth');

        $sequenceStateWriter->write($spinnerState);
    }

    protected function getSpinnerStateMock(): MockObject&ISequenceState
    {
        return $this->createMock(ISequenceState::class);
    }

    #[Test]
    public function canWriteIfInitialized(): void
    {
        $initializationResolver = $this->getInitializationResolverMock();
        $initializationResolver
            ->expects(self::once())
            ->method('isEnabled')
            ->willReturn(true)
        ;

        $cursor = $this->getCursorMock();
        $cursor->expects(self::once())->method('erase')->willReturnSelf();
        $cursor->expects(self::once())->method('moveLeft')->willReturnSelf();

        $output = $this->getBufferedOutputMock();

        $output->expects(self::once())->method('append');
        $output->expects(self::exactly(2))->method('flush');

        $sequenceStateWriter = $this->getTesteeInstance(
            output: $output,
            cursor: $cursor,
            initializationResolver: $initializationResolver,
        );

        $spinnerState = $this->getSpinnerStateMock();
        $spinnerState->expects(self::once())->method('getSequence');
        $spinnerState->expects(self::once())->method('getWidth');
        $spinnerState->expects(self::once())->method('getPreviousWidth');

        $sequenceStateWriter->initialize();
        $sequenceStateWriter->write($spinnerState);
    }
}
