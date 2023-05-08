<?php

declare(strict_types=1);

namespace AlecRabbit\Tests\Unit\Spinner\Extras\DriverTest;

use PHPUnit\Framework\Attributes\Test;

final class MethodRemoveDriverTest extends TestCaseForDriver
{
    #[Test]
    public function canRemove(): void
    {
        $observer = $this->getObserverMock();

        $driver =
            $this->getTesteeInstance(
                observer: $observer,
            );

        $spinner = $this->getSpinnerMock();

        $driver->add($spinner);

        $observer
            ->expects(self::once())
            ->method('update')
            ->with($driver)
        ;
        $spinner
            ->expects(self::once())
            ->method('detach')
            ->with($driver)
        ;

        $driver->remove($spinner);
    }
}
