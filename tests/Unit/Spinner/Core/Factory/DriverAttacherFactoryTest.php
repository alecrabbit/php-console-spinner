<?php

declare(strict_types=1);

namespace AlecRabbit\Tests\Unit\Spinner\Core\Factory;

use AlecRabbit\Spinner\Core\DriverAttacher;
use AlecRabbit\Spinner\Core\Factory\Contract\IDriverAttacherFactory;
use AlecRabbit\Spinner\Core\Factory\DriverAttacherFactory;
use AlecRabbit\Spinner\Core\Loop\Contract\ILoop;
use AlecRabbit\Tests\TestCase\TestCaseWithPrebuiltMocksAndStubs;
use PHPUnit\Framework\Attributes\Test;

final class DriverAttacherFactoryTest extends TestCaseWithPrebuiltMocksAndStubs
{
    #[Test]
    public function canBeCreated(): void
    {
        $driverAttacherFactory = $this->getTesteeInstance();

        self::assertInstanceOf(DriverAttacherFactory::class, $driverAttacherFactory);
    }

    public function getTesteeInstance(
        ?ILoop $loop = null,
    ): IDriverAttacherFactory {
        return
            new DriverAttacherFactory(
                loop: $loop ?? $this->getLoopMock(),
            );
    }


    #[Test]
    public function canGetAttacher(): void
    {
        $driverAttacherFactory = $this->getTesteeInstance();

        self::assertInstanceOf(DriverAttacherFactory::class, $driverAttacherFactory);
        self::assertInstanceOf(DriverAttacher::class, $driverAttacherFactory->getAttacher());
    }
}
