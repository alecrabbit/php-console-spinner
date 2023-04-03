<?php

declare(strict_types=1);
// 03.04.23
namespace AlecRabbit\Tests\Spinner\Unit\Spinner\Core\Factory;

use AlecRabbit\Spinner\Core\Factory\Contract\ITimerBuilder;
use AlecRabbit\Spinner\Core\Factory\TimerBuilder;
use AlecRabbit\Spinner\Core\Timer;
use AlecRabbit\Tests\Spinner\TestCase\TestCaseWithPrebuiltMocks;
use PHPUnit\Framework\Attributes\Test;


final class TimerBuilderTest extends TestCaseWithPrebuiltMocks
{
    #[Test]
    public function canBeCreated(): void
    {
        $timerFactory = $this->getTesteeInstance();

        self::assertInstanceOf(TimerBuilder::class, $timerFactory);
    }

    public function getTesteeInstance(): ITimerBuilder
    {
        return
            new TimerBuilder();
    }

    #[Test]
    public function canCreateTimer(): void
    {
        $timerFactory = $this->getTesteeInstance();

        self::assertInstanceOf(Timer::class, $timerFactory->build());
    }
}
