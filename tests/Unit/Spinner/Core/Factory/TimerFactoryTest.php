<?php

declare(strict_types=1);
// 03.04.23
namespace AlecRabbit\Tests\Spinner\Unit\Spinner\Core\Factory;

use AlecRabbit\Spinner\Core\Config\ITimerFactory;
use AlecRabbit\Spinner\Core\Factory\TimerFactory;
use AlecRabbit\Spinner\Core\Timer;
use AlecRabbit\Tests\Spinner\TestCase\TestCaseWithPrebuiltMocks;
use PHPUnit\Framework\Attributes\Test;


final class TimerFactoryTest extends TestCaseWithPrebuiltMocks
{
    #[Test]
    public function canBeCreated(): void
    {
        $timerFactory = $this->getTesteeInstance();

        self::assertInstanceOf(TimerFactory::class, $timerFactory);
    }
    #[Test]
    public function canCreateTimer(): void
    {
        $timerFactory = $this->getTesteeInstance();

        self::assertInstanceOf(Timer::class, $timerFactory->createTimer());
    }

    public function getTesteeInstance(): ITimerFactory
    {
        return
            new TimerFactory();
    }
}
