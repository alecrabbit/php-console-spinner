<?php

declare(strict_types=1);
// 03.04.23
namespace AlecRabbit\Tests\Unit\Spinner\Core;

use AlecRabbit\Spinner\Core\Contract\ITimerBuilder;
use AlecRabbit\Spinner\Core\Timer;
use AlecRabbit\Spinner\Core\TimerBuilder;
use AlecRabbit\Tests\TestCase\TestCaseWithPrebuiltMocks;
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
