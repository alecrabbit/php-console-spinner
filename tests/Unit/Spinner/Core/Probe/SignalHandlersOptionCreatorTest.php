<?php

declare(strict_types=1);

namespace Unit\Spinner\Core\Probe;

use AlecRabbit\Spinner\Contract\Option\SignalHandlersOption;
use AlecRabbit\Spinner\Core\Probe\SignalHandlersOptionCreator;
use AlecRabbit\Tests\TestCase\TestCase;
use PHPUnit\Framework\Attributes\Test;

final class SignalHandlersOptionCreatorTest extends TestCase
{
    #[Test]
    public function canCreateOption(): void
    {
        $signalHandlersOption = SignalHandlersOptionCreator::create();

        if (function_exists('pcntl_signal')) {
            self::assertSame(SignalHandlersOption::ENABLED, $signalHandlersOption);
        } else {
            self::assertSame(SignalHandlersOption::DISABLED, $signalHandlersOption);
        }
    }
}
