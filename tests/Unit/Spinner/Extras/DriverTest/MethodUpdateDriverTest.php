<?php

declare(strict_types=1);

namespace AlecRabbit\Tests\Unit\Spinner\Extras\DriverTest;

use PHPUnit\Framework\Attributes\Test;

final class MethodUpdateDriverTest extends TestCaseForDriver
{
    #[Test]
    public function canUpdate(): void
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

        $driver->update($spinner);
    }
}
