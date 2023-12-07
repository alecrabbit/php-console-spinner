<?php

declare(strict_types=1);

namespace AlecRabbit\Tests\Spinner\Unit\Core\Probe;

use AlecRabbit\Spinner\Contract\Option\SignalHandlingOption;
use AlecRabbit\Spinner\Core\Probe\SignalHandlingOptionCreator;
use AlecRabbit\Tests\TestCase\PcntlAwareTestCase;
use PHPUnit\Framework\Attributes\Test;

final class SignalHandlingOptionCreatorTest extends PcntlAwareTestCase
{
    #[Test]
    public function canCreateOption(): void
    {
        $signalHandlersOption = (new SignalHandlingOptionCreator)->create();

        if ($this->isPcntlExtensionAvailable()) {
            self::assertSame(SignalHandlingOption::ENABLED, $signalHandlersOption);
        } else {
            self::assertSame(SignalHandlingOption::DISABLED, $signalHandlersOption);
        }
    }
}
