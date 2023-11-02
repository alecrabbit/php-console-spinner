<?php

declare(strict_types=1);

namespace AlecRabbit\Tests\Unit\Spinner\Core\Settings;

use AlecRabbit\Spinner\Contract\IFrame;
use AlecRabbit\Spinner\Core\Settings\Contract\IHandlerCreator;
use AlecRabbit\Spinner\Core\Settings\Contract\ISignalHandlerCreator;
use AlecRabbit\Spinner\Core\Settings\SignalHandlerCreator;
use AlecRabbit\Tests\TestCase\TestCase;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\MockObject\MockObject;

final class SignalHandlerCreatorTest extends TestCase
{
    #[Test]
    public function canBeInstantiated(): void
    {
        $settings = $this->getTesteeInstance();

        self::assertInstanceOf(SignalHandlerCreator::class, $settings);
    }

    public function getTesteeInstance(
        ?int $signal = null,
        ?IHandlerCreator $handlerCreator = null,
    ): ISignalHandlerCreator {
        return
            new SignalHandlerCreator(
                signal: $signal ?? 65535,
                handlerCreator: $handlerCreator ?? $this->getHandlerCreatorMock(),
            );
    }

    private function getHandlerCreatorMock(): MockObject&IHandlerCreator
    {
        return $this->createMock(IHandlerCreator::class);
    }

    #[Test]
    public function canGetSignal(): void
    {
        $signal = 0;

        $settings = $this->getTesteeInstance(
            signal: $signal,
        );

        self::assertSame($signal, $settings->getSignal());
    }

    #[Test]
    public function canGetHandlerCreator(): void
    {
        $handlerCreator = $this->getHandlerCreatorMock();

        $settings = $this->getTesteeInstance(
            handlerCreator: $handlerCreator,
        );

        self::assertSame($handlerCreator, $settings->getHandlerCreator());
    }

    protected function getFrameMock(): MockObject&IFrame
    {
        return $this->createMock(IFrame::class);
    }
}
