<?php

declare(strict_types=1);
// 03.04.23
namespace AlecRabbit\Tests\Unit\Spinner\Core;

use AlecRabbit\Spinner\Core\Contract\ILoopSetup;
use AlecRabbit\Spinner\Core\Loop\Contract\ILoop;
use AlecRabbit\Spinner\Core\LoopSetup;
use AlecRabbit\Tests\TestCase\TestCaseWithPrebuiltMocksAndStubs;
use PHPUnit\Framework\Attributes\Test;


final class LoopSetupTest extends TestCaseWithPrebuiltMocksAndStubs
{
    #[Test]
    public function canBeCreated(): void
    {
        $loopSetup = $this->getTesteeInstance();

        self::assertInstanceOf(LoopSetup::class, $loopSetup);
        self::assertFalse(self::getValue('asynchronous', $loopSetup));
        self::assertFalse(self::getValue('signalHandlersEnabled', $loopSetup));
        self::assertFalse(self::getValue('autoStartEnabled', $loopSetup));
    }

    public function getTesteeInstance(
        ?ILoop $loop = null,
    ): ILoopSetup {
        return
            new LoopSetup(
                loop: $loop ?? $this->getLoopMock(),
            );
    }

    #[Test]
    public function doesNothingWithDefaults(): void
    {
        $loop = $this->getLoopMock();
        $loop
            ->expects(self::never())
            ->method('autoStart')
        ;
        $loop
            ->expects(self::never())
            ->method('onSignal')
        ;

        $this->getTesteeInstance($loop)
            ->setup($this->getSpinnerMock())
        ;
    }

    #[Test]
    public function parametersCanBeSet(): void
    {
        $loopSetup = $this->getTesteeInstance();
        self::assertFalse(self::getValue('asynchronous', $loopSetup));
        self::assertFalse(self::getValue('signalHandlersEnabled', $loopSetup));
        self::assertFalse(self::getValue('autoStartEnabled', $loopSetup));

        $loopSetup
            ->asynchronous(true)
            ->enableSignalHandlers(true)
            ->enableAutoStart(true)
        ;

        self::assertTrue(self::getValue('asynchronous', $loopSetup));
        self::assertTrue(self::getValue('signalHandlersEnabled', $loopSetup));
        self::assertTrue(self::getValue('autoStartEnabled', $loopSetup));
    }

    #[Test]
    public function does(): void
    {
        $loop = $this->getLoopMock();
        $loop
            ->expects(self::once())
            ->method('autoStart')
        ;
        $loop
            ->expects(self::once())
            ->method('onSignal')
        ;

        $loopSetup = $this->getTesteeInstance($loop);

        $loopSetup
            ->asynchronous(true)
            ->enableSignalHandlers(true)
            ->enableAutoStart(true)
        ;

        $loopSetup
            ->setup($this->getSpinnerMock())
        ;
    }
}
