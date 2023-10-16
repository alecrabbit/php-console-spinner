<?php

declare(strict_types=1);

namespace AlecRabbit\Tests\Unit\Spinner\Core\Probe;

use AlecRabbit\Spinner\Contract\Option\SignalHandlingOption;
use AlecRabbit\Spinner\Core\Probe\SignalHandlersOptionCreator;
use AlecRabbit\Tests\TestCase\TestCase;
use PHPUnit\Framework\Attributes\Test;

final class SignalHandlersOptionCreatorTest extends TestCase
{
    #[Test]
    public function canCreateOption(): void
    {
        $signalHandlersOption = (new SignalHandlersOptionCreator)->create();

        if (function_exists('pcntl_signal')) {
            self::assertSame(SignalHandlingOption::ENABLED, $signalHandlersOption);
        } else {
            self::assertSame(SignalHandlingOption::DISABLED, $signalHandlersOption);
        }
    }
}
