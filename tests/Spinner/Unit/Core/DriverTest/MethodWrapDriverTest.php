<?php

declare(strict_types=1);

namespace AlecRabbit\Tests\Spinner\Unit\Core\DriverTest;

use AlecRabbit\Spinner\Contract\IDeltaTimer;
use AlecRabbit\Spinner\Contract\IInterval;
use AlecRabbit\Spinner\Contract\IObserver;
use AlecRabbit\Spinner\Contract\ISubject;
use AlecRabbit\Spinner\Core\A\ADriver;
use AlecRabbit\Spinner\Core\Builder\Contract\ISequenceStateBuilder;
use AlecRabbit\Spinner\Core\Config\Contract\IDriverConfig;
use AlecRabbit\Spinner\Core\Contract\IDriver;
use AlecRabbit\Spinner\Core\Contract\IDriverMessages;
use AlecRabbit\Spinner\Core\Contract\IIntervalComparator;
use AlecRabbit\Spinner\Core\Contract\ISequenceState;
use AlecRabbit\Spinner\Core\Contract\ISpinner;
use AlecRabbit\Spinner\Core\Output\Contract\ISequenceStateWriter;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\MockObject\MockObject;
use RuntimeException;

final class MethodWrapDriverTest extends TestCaseForDriver
{
    #[Test]
    public function canWrap(): void
    {
        $state = $this->getSequenceStateMock();

        $stateWriter = $this->getSequenceStateWriterMock();
        // Make sure method erase() is called. See ADriver::wrap()
        $stateWriter
            ->expects(self::once())
            ->method('erase')
            ->with(self::identicalTo($state))
        ;
        // Make sure method render() is called. See ADriver::wrap()
        $stateWriter
            ->expects(self::once())
            ->method('write')
            ->with(self::identicalTo($state))
        ;

        $driver =
            $this->getTesteeInstance(
                stateWriter: $stateWriter,
                state: $state,
            );

        $counter = 0;
        $callback = static function () use (&$counter) {
            $counter++;
        };

        $wrapped = $driver->wrap($callback);

        $wrapped();
        // Make sure wrapped callback is called. See ADriver::wrap()
        self::assertEquals(1, $counter);
    }

    private function getSequenceStateMock(): MockObject&ISequenceState
    {
        return $this->createMock(ISequenceState::class);
    }

    /**
     * Get testee instance derived from abstract class ADriver.
     */
    public function getTesteeInstance(
        ?IDeltaTimer $deltaTimer = null,
        ?ISequenceStateWriter $stateWriter = null,
        ?ISequenceStateBuilder $stateBuilder = null,
        ?IInterval $initialInterval = null,
        ?IDriverMessages $driverMessages = null,
        ?IIntervalComparator $intervalComparator = null,
        ?IObserver $observer = null,
        ?ISequenceState $state = null,
    ): IDriver {
        return
            new class(
                driverMessages: $driverMessages ?? $this->getDriverMessagesMock(),
                deltaTimer: $deltaTimer ?? $this->getDeltaTimerMock(),
                initialInterval: $initialInterval ?? $this->getIntervalMock(),
                stateWriter: $stateWriter ?? $this->getSequenceStateWriterMock(),
                stateBuilder: $stateBuilder ?? $this->getSequenceStateBuilderMock(),
                state: $state ?? $this->getSequenceStateMock(),
                intervalComparator: $intervalComparator ?? $this->getIntervalComparatorMock(),
                observer: $observer,
            ) extends ADriver {
                public function __construct(
                    IDriverMessages $driverMessages,
                    IDeltaTimer $deltaTimer,
                    IInterval $initialInterval,
                    ISequenceStateWriter $stateWriter,
                    ISequenceStateBuilder $stateBuilder,
                    IIntervalComparator $intervalComparator,
                    private readonly ISequenceState $state,
                    ?IObserver $observer = null,
                ) {
                    parent::__construct(
                        $driverMessages,
                        $deltaTimer,
                        $initialInterval,
                        $stateWriter,
                        $stateBuilder,
                        $observer
                    );
                }

                protected function erase(): void
                {
                    $this->stateWriter->erase($this->state);
                }

                public function render(?float $dt = null): void
                {
                    $this->stateWriter->write($this->state);
                }

                public function add(ISpinner $spinner): void
                {
                    throw new RuntimeException('Not implemented. Should not be called.');
                }

                public function remove(ISpinner $spinner): void
                {
                    throw new RuntimeException('Not implemented. Should not be called.');
                }

                public function update(ISubject $subject): void
                {
                    throw new RuntimeException('Not implemented. Should not be called.');
                }

                public function has(ISpinner $spinner): bool
                {
                    throw new RuntimeException('Not implemented. Should not be called.');
                }
            };
    }
}
