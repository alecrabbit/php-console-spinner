<?php

declare(strict_types=1);

namespace AlecRabbit\Tests\Spinner\Unit\Core\Driver\DriverTest;

use AlecRabbit\Spinner\Contract\IInterval;
use AlecRabbit\Spinner\Contract\IObserver;
use AlecRabbit\Spinner\Contract\ISubject;
use AlecRabbit\Spinner\Core\A\ADriver;
use AlecRabbit\Spinner\Core\Builder\Contract\ISequenceStateBuilder;
use AlecRabbit\Spinner\Core\Contract\IDriver;
use AlecRabbit\Spinner\Core\Contract\IDriverMessages;
use AlecRabbit\Spinner\Core\Contract\IIntervalComparator;
use AlecRabbit\Spinner\Core\Contract\IRenderer;
use AlecRabbit\Spinner\Core\Contract\ISpinner;
use AlecRabbit\Spinner\Core\Output\Contract\ISequenceStateWriter;
use PHPUnit\Framework\Attributes\Test;
use RuntimeException;

final class MethodWrapDriverTest extends TestCaseForDriver
{
    #[Test]
    public function canWrap(): void
    {
        $spinner = $this->getSpinnerMock();
        $renderer = $this->getRendererMock();
        // Make sure method erase() is called. See ADriver::wrap()
        $renderer
            ->expects(self::once())
            ->method('erase')
            ->with(self::identicalTo($spinner))
        ;
        // Make sure method render() is called. See ADriver::wrap()
        $renderer
            ->expects(self::once())
            ->method('render')
            ->with(self::identicalTo($spinner), self::isNull())
        ;

        $driver =
            $this->getTesteeInstance(
                renderer: $renderer,
                spinner: $spinner,
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

    /**
     * Get testee instance derived from abstract class ADriver.
     */
    public function getTesteeInstance(
        ?IRenderer $renderer = null,
        ?ISequenceStateWriter $stateWriter = null,
        ?ISequenceStateBuilder $stateBuilder = null,
        ?IInterval $initialInterval = null,
        ?IDriverMessages $driverMessages = null,
        ?IIntervalComparator $intervalComparator = null,
        ?IObserver $observer = null,
        ?ISpinner $spinner = null,
    ): IDriver {
        return
            new class(
                renderer: $renderer ?? $this->getRendererMock(),
                driverMessages: $driverMessages ?? $this->getDriverMessagesMock(),
                initialInterval: $initialInterval ?? $this->getIntervalMock(),
                stateBuilder: $stateBuilder ?? $this->getSequenceStateBuilderMock(),
                spinner: $spinner ?? $this->getSpinnerMock(),
                intervalComparator: $intervalComparator ?? $this->getIntervalComparatorMock(),
                observer: $observer,
            ) extends ADriver {
                public function __construct(
                    IRenderer $renderer,
                    IDriverMessages $driverMessages,
                    IInterval $initialInterval,
                    ISequenceStateBuilder $stateBuilder,
                    IIntervalComparator $intervalComparator,
                    private readonly ISpinner $spinner,
                    ?IObserver $observer = null,
                ) {
                    parent::__construct(
                        initialInterval: $initialInterval,
                        driverMessages: $driverMessages,
                        renderer: $renderer,
                        observer: $observer
                    );
                }

                protected function erase(): void
                {
                    $this->renderer->erase($this->spinner);
                }

                public function render(?float $dt = null): void
                {
                    $this->renderer->render($this->spinner, $dt);
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
