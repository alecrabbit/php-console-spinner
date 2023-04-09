<?php

declare(strict_types=1);

namespace Unit\Spinner\Core;

use AlecRabbit\Spinner\Contract\IDriver;
use AlecRabbit\Spinner\Contract\IInterval;
use AlecRabbit\Spinner\Contract\ISpinner;
use AlecRabbit\Spinner\Contract\ITimer;
use AlecRabbit\Spinner\Contract\Output\IBufferedOutput;
use AlecRabbit\Spinner\Contract\Output\IOutput;
use AlecRabbit\Spinner\Core\Driver;
use AlecRabbit\Spinner\Core\Output\Contract\ICursor;
use AlecRabbit\Tests\TestCase\TestCaseWithPrebuiltMocksAndStubs;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\MockObject\MockObject;

final class DriverTest extends TestCaseWithPrebuiltMocksAndStubs
{
    #[Test]
    public function canBeCreated(): void
    {
        $driver = $this->getTesteeInstance();

        self::assertInstanceOf(Driver::class, $driver);

        self::assertCount(0, self::getValue('spinners', $driver));
        self::assertFalse(self::getValue('initialized', $driver));
    }

    public function getTesteeInstance(
        ?IBufferedOutput $output = null,
        ?ICursor $cursor = null,
        ?ITimer $timer = null,
        ?string $interruptMessage = null,
        ?string $finalMessage = null,
        ?IInterval $interval = null,
    ): IDriver {
        return
            new Driver(
                output: $output ?? $this->getBufferedOutputMock(),
                cursor: $cursor ?? $this->getCursorMock(),
                timer: $timer ?? $this->getTimerMock(),
                interruptMessage: $interruptMessage ?? '--interrupted--',
                finalMessage: $finalMessage ?? '--finalized--',
                interval: $interval ?? $this->getIntervalMock(),
            );
    }

    #[Test]
    public function canRender(): void
    {
        $spinner = $this->getSpinnerMock();

        $driver = $this->getTesteeInstance();

        $driver->add($spinner);

        $driver->render();

        self::assertTrue(true); // TODO: Implement render() method.
    }

    #[Test]
    public function hidesCursorOnInitializeAndOnInterruptShowsCursorAndWritesToOutput(): void
    {
        $interruptMessage = 'interruptMessage';

        $cursor = $this->getCursorMock();
        $cursor
            ->expects(self::once())
            ->method('hide')
        ;
        $cursor
            ->expects(self::once())
            ->method('show')
        ;

        $output = $this->getBufferedOutputMock();
        $output
            ->expects(self::once())
            ->method('write')
            ->with(self::equalTo($interruptMessage))
        ;

        $driver =
            $this->getTesteeInstance(
                output: $output,
                cursor: $cursor,
            );

        $driver->initialize();
        $driver->interrupt($interruptMessage);
    }

    #[Test]
    public function canBeInitialized(): void
    {
        $driver = $this->getTesteeInstance();

        $driver->initialize();

        self::assertTrue(self::getValue('initialized', $driver));
    }

    #[Test]
    public function canAddAndRemoveSpinner(): void
    {
        $driver = $this->getTesteeInstance();

        $spinner = $this->getSpinnerMock();

        $driver->add($spinner);

        self::assertCount(1, self::getValue('spinners', $driver));

        $driver->remove($spinner);

        self::assertCount(0, self::getValue('spinners', $driver));
    }
}
