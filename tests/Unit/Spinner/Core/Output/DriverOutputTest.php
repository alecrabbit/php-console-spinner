<?php

declare(strict_types=1);

namespace AlecRabbit\Tests\Unit\Spinner\Core\Output;

use AlecRabbit\Spinner\Contract\Output\IBufferedOutput;
use AlecRabbit\Spinner\Core\Contract\ISpinnerState;
use AlecRabbit\Spinner\Core\Output\Contract\IConsoleCursor;
use AlecRabbit\Spinner\Core\Output\Contract\IDriverOutput;
use AlecRabbit\Spinner\Core\Output\DriverOutput;
use AlecRabbit\Tests\TestCase\TestCase;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\MockObject\Stub;

final class DriverOutputTest extends TestCase
{
    #[Test]
    public function createdUninitialized(): void
    {
        $driverOutput = $this->getTesteeInstance();

        self::assertInstanceOf(DriverOutput::class, $driverOutput);
        self::assertFalse(self::getPropertyValue('initialized', $driverOutput));
    }

    public function getTesteeInstance(
        ?IBufferedOutput $output = null,
        ?IConsoleCursor $cursor = null,
    ): IDriverOutput {
        return
            new DriverOutput(
                output: $output ?? $this->getBufferedOutputMock(),
                cursor: $cursor ?? $this->getCursorMock(),
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

    #[Test]
    public function canBeFinalizedIfInitialized(): void
    {
        $cursor = $this->getCursorMock();
        $cursor->expects(self::once())->method('hide');
        $cursor->expects(self::once())->method('show');

        $output = $this->getBufferedOutputMock();

        $message = 'final message';

        $output->expects(self::once())->method('append')->with($message);
        $output->expects(self::exactly(2))->method('flush');

        $driverOutput = $this->getTesteeInstance(output: $output, cursor: $cursor);

        $driverOutput->initialize();
        $driverOutput->finalize($message);

        self::assertFalse(self::getPropertyValue('initialized', $driverOutput));
    }

    #[Test]
    public function canBeFinalizedIfInitializedWithEmptyMessage(): void
    {
        $cursor = $this->getCursorMock();
        $cursor->expects(self::once())->method('hide');
        $cursor->expects(self::once())->method('show');

        $output = $this->getBufferedOutputMock();

        $message = '';

        $output->expects(self::never())->method('append')->with($message);
        $output->expects(self::exactly(2))->method('flush');

        $driverOutput = $this->getTesteeInstance(output: $output, cursor: $cursor);

        $driverOutput->initialize();
        $driverOutput->finalize($message);

        self::assertFalse(self::getPropertyValue('initialized', $driverOutput));
    }

    #[Test]
    public function canBeFinalizedIfInitializedWithNoMessage(): void
    {
        $cursor = $this->getCursorMock();
        $cursor->expects(self::once())->method('hide');
        $cursor->expects(self::once())->method('show');

        $output = $this->getBufferedOutputMock();

        $message = null;

        $output->expects(self::never())->method('append')->with($message);
        $output->expects(self::exactly(2))->method('flush');

        $driverOutput = $this->getTesteeInstance(output: $output, cursor: $cursor);

        $driverOutput->initialize();
        self::assertTrue(self::getPropertyValue('initialized', $driverOutput));
        $driverOutput->finalize($message);
    }

    #[Test]
    public function canEraseIfInitialized(): void
    {
        $cursor = $this->getCursorMock();
        $cursor->expects(self::once())->method('erase')->willReturnSelf();

        $driverOutput = $this->getTesteeInstance(cursor: $cursor);

        $driverOutput->initialize();
        $driverOutput->erase($this->getSpinnerStateStub());
    }

    protected function getSpinnerStateStub(): Stub&ISpinnerState
    {
        return $this->createStub(ISpinnerState::class);
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

        $driverOutput = $this->getTesteeInstance(cursor: $cursor);

        $driverOutput->erase($this->getSpinnerStateStub());
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

        $driverOutput = $this->getTesteeInstance($output, $cursor);

        $driverOutput->finalize($message);
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

        $driverOutput = $this->getTesteeInstance($output, $cursor);

        $spinnerState = $this->getSpinnerStateMock();
        $spinnerState->expects(self::never())->method('getSequence');
        $spinnerState->expects(self::never())->method('getWidth');
        $spinnerState->expects(self::never())->method('getPreviousWidth');

        $driverOutput->write($spinnerState);
    }

    protected function getSpinnerStateMock(): MockObject&ISpinnerState
    {
        return $this->createMock(ISpinnerState::class);
    }

    #[Test]
    public function canWriteIfInitialized(): void
    {
        $cursor = $this->getCursorMock();
        $cursor->expects(self::once())->method('erase')->willReturnSelf();
        $cursor->expects(self::once())->method('moveLeft')->willReturnSelf();

        $output = $this->getBufferedOutputMock();

        $output->expects(self::once())->method('append');
        $output->expects(self::exactly(2))->method('flush');

        $driverOutput = $this->getTesteeInstance(output: $output, cursor: $cursor);

        $spinnerState = $this->getSpinnerStateMock();
        $spinnerState->expects(self::once())->method('getSequence');
        $spinnerState->expects(self::once())->method('getWidth');
        $spinnerState->expects(self::once())->method('getPreviousWidth');

        $driverOutput->initialize();
        $driverOutput->write($spinnerState);
    }
}
