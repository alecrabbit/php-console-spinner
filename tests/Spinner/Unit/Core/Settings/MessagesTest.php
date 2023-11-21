<?php

declare(strict_types=1);

namespace AlecRabbit\Tests\Spinner\Unit\Core\Settings;

use AlecRabbit\Spinner\Core\Settings\Contract\IMessages;
use AlecRabbit\Spinner\Core\Settings\Messages;
use AlecRabbit\Tests\TestCase\TestCase;
use PHPUnit\Framework\Attributes\Test;

final class MessagesTest extends TestCase
{
    #[Test]
    public function canBeInstantiated(): void
    {
        $driverMessages = $this->getTesteeInstance();

        self::assertInstanceOf(Messages::class, $driverMessages);
    }

    protected function getTesteeInstance(
        ?string $finalMessage = null,
        ?string $interruptionMessage = null,
    ): IMessages {
        return new Messages(
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
