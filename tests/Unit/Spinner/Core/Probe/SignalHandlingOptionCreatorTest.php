<?php

declare(strict_types=1);

namespace AlecRabbit\Tests\Unit\Spinner\Core\Probe;

use AlecRabbit\Spinner\Contract\Option\SignalHandlingOption;
use AlecRabbit\Spinner\Core\Probe\SignalHandlingOptionCreator;
use AlecRabbit\Tests\TestCase\TestCase;
use PHPUnit\Framework\Attributes\Test;

final class SignalHandlingOptionCreatorTest extends TestCase
{
    #[Test]
    public function canCreateOption(): void
    {
        $signalHandlersOption = (new SignalHandlingOptionCreator)->create();

        if (function_exists('pcntl_signal')) {
            self::assertSame(SignalHandlingOption::ENABLED, $signalHandlersOption);
        } else {
            self::assertSame(SignalHandlingOption::DISABLED, $signalHandlersOption);
        }
    }
}
