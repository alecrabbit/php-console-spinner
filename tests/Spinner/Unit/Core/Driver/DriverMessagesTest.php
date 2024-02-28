<?php

declare(strict_types=1);

namespace AlecRabbit\Tests\Spinner\Unit\Core\Driver;

use AlecRabbit\Spinner\Core\Contract\IDriverMessages;
use AlecRabbit\Spinner\Core\Driver\DriverMessages;
use AlecRabbit\Tests\TestCase\TestCase;
use PHPUnit\Framework\Attributes\Test;

final class DriverMessagesTest extends TestCase
{
    #[Test]
    public function canBeInstantiated(): void
    {
        $driverMessages = $this->getTesteeInstance();

        self::assertInstanceOf(DriverMessages::class, $driverMessages);
    }

    protected function getTesteeInstance(
        string $finalMessage = '',
        string $interruptionMessage = '',
    ): IDriverMessages {
        return new DriverMessages(
            finalMessage: $finalMessage,
            interruptionMessage: $interruptionMessage,
        );
    }

    #[Test]
    public function canGetFinalMessage(): void
    {
        $finalMessage = 'Done!';

        $driverMessages = $this->getTesteeInstance(
            finalMessage: $finalMessage,
        );
        self::assertEquals($finalMessage, $driverMessages->getFinalMessage());
    }

    #[Test]
    public function canGetInterruptionMessage(): void
    {
        $interruptionMessage = 'Interrupted!';

        $driverMessages = $this->getTesteeInstance(
            interruptionMessage: $interruptionMessage,
        );
        self::assertEquals($interruptionMessage, $driverMessages->getInterruptionMessage());
    }
}
