<?php

declare(strict_types=1);

namespace AlecRabbit\Tests\Spinner\Unit\Core\Driver\DriverTest;

use PHPUnit\Framework\Attributes\Test;

final class MethodFinalizeDriverTest extends TestCaseForDriver
{
    #[Test]
    public function canFinalizeInitialized(): void
    {
        $finalMessage = 'finalMessage';

        $renderer = $this->getRendererMock();
        $renderer
            ->expects(self::once())
            ->method('finalize')
            ->with(self::equalTo($finalMessage))
        ;

        $driver =
            $this->getTesteeInstance(
                renderer: $renderer
            );

        $driver->initialize();
        $driver->finalize($finalMessage);
    }

    #[Test]
    public function canFinalizeInitializedWithEmptyFinalMessage(): void
    {
        $finalMessage = '';

        $renderer = $this->getRendererMock();
        $renderer
            ->expects(self::once())
            ->method('finalize')
            ->with(self::equalTo($finalMessage))
        ;

        $driver =
            $this->getTesteeInstance(
                renderer: $renderer
            );

        $driver->initialize();
        $driver->finalize($finalMessage);
    }

    #[Test]
    public function canFinalizeInitializedWithNoMessage(): void
    {
        $message = '';
        $driverMessages = $this->getDriverMessagesMock();
        $driverMessages
            ->expects(self::once())
            ->method('getFinalMessage')
            ->willReturn($message)
        ;

        $renderer = $this->getRendererMock();
        $renderer
            ->expects(self::once())
            ->method('finalize')
            ->with(self::identicalTo($message))
        ;

        $driver =
            $this->getTesteeInstance(
                renderer: $renderer,
                driverMessages: $driverMessages,
            );

        $driver->initialize();
        $driver->finalize();
    }


    #[Test]
    public function canFinalizeUninitialized(): void
    {
        $finalMessage = 'finalMessage';

        $renderer = $this->getRendererMock();
        $renderer
            ->expects(self::once())
            ->method('finalize')
        ;

        $driver =
            $this->getTesteeInstance(
                renderer: $renderer
            );

        $driver->finalize($finalMessage);
    }

    #[Test]
    public function canFinalizeUninitializedWithNoMessage(): void
    {
        $renderer = $this->getRendererMock();
        $renderer
            ->expects(self::once())
            ->method('finalize')
        ;
        $driver =
            $this->getTesteeInstance(
                renderer: $renderer
            );

        $driver->finalize();
    }

    #[Test]
    public function erasesAllAddedSpinners(): void
    {
        $renderer = $this->getRendererMock();
        $renderer
            ->expects(self::exactly(2))
            ->method('erase')
        ;

        $driver =
            $this->getTesteeInstance(
                renderer: $renderer
            );

        $driver->initialize();

        $spinnerOne = $this->getSpinnerMock();

        $spinnerTwo = $this->getSpinnerMock();

        $driver->add($spinnerOne);
        $driver->add($spinnerTwo);
        $driver->finalize();
    }
}
