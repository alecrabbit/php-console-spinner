<?php

declare(strict_types=1);

namespace AlecRabbit\Tests\Unit\Spinner\Extras\DriverTest;

use PHPUnit\Framework\Attributes\Test;

final class MethodAddDriverTest extends TestCaseForDriver
{
    #[Test]
    public function canAdd(): void
    {
        $observer = $this->getObserverMock();

        $driver =
            $this->getTesteeInstance(
                observer: $observer,
            );

        $observer
            ->expects(self::once())
            ->method('update')
            ->with($driver)
        ;

        $spinner = $this->getSpinnerMock();
        $spinner
            ->expects(self::once())
            ->method('attach')
            ->with($driver)
        ;


        $driver->add($spinner);
    }
}
