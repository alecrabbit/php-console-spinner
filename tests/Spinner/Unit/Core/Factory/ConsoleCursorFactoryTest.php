<?php

declare(strict_types=1);

namespace AlecRabbit\Tests\Spinner\Unit\Core\Factory;

use AlecRabbit\Spinner\Contract\Mode\CursorMode;
use AlecRabbit\Spinner\Core\Builder\Contract\IConsoleCursorBuilder;
use AlecRabbit\Spinner\Core\Config\Contract\IOutputConfig;
use AlecRabbit\Spinner\Core\Factory\ConsoleCursorFactory;
use AlecRabbit\Spinner\Core\Factory\Contract\IConsoleCursorFactory;
use AlecRabbit\Spinner\Core\Output\Contract\IBuffer;
use AlecRabbit\Spinner\Core\Output\Contract\IConsoleCursor;
use AlecRabbit\Tests\TestCase\TestCase;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\MockObject\Stub;

final class ConsoleCursorFactoryTest extends TestCase
{
    #[Test]
    public function canBeInstantiated(): void
    {
        $cursorFactory = $this->getTesteeInstance();

        self::assertInstanceOf(ConsoleCursorFactory::class, $cursorFactory);
    }

    public function getTesteeInstance(
        ?IBuffer $buffer = null,
        ?IConsoleCursorBuilder $cursorBuilder = null,
        ?IOutputConfig $outputConfig = null,
    ): IConsoleCursorFactory {
        return new ConsoleCursorFactory(
            buffer: $buffer ?? $this->getBufferMock(),
            cursorBuilder: $cursorBuilder ?? $this->getCursorBuilderMock(),
            outputConfig: $outputConfig ?? $this->getOutputConfigMock(),
        );
    }

    private function getBufferMock(): MockObject&IBuffer
    {
        return $this->createMock(IBuffer::class);
    }

    protected function getCursorBuilderMock(): MockObject&IConsoleCursorBuilder
    {
        return $this->createMock(IConsoleCursorBuilder::class);
    }

    private function getOutputConfigMock(?CursorMode $cursorVisibilityMode = null): MockObject&IOutputConfig
    {
        return $this->createConfiguredMock(
            IOutputConfig::class,
            [
                'getCursorMode' => $cursorVisibilityMode ?? CursorMode::VISIBLE,
            ]
        );
    }

    #[Test]
    public function canCreate(): void
    {
        $cursorVisibilityMode = CursorMode::HIDDEN;
        $outputConfig = $this->getOutputConfigMock($cursorVisibilityMode);

        $cursorStub = $this->getCursorStub();

        $cursorBuilder = $this->getCursorBuilderMock();

        $cursorBuilder
            ->expects(self::once())
            ->method('withBuffer')
            ->willReturnSelf()
        ;

        $cursorBuilder
            ->expects(self::once())
            ->method('withCursorMode')
            ->with(self::identicalTo($cursorVisibilityMode))
            ->willReturnSelf()
        ;

        $cursorBuilder
            ->expects(self::once())
            ->method('build')
            ->willReturn($cursorStub)
        ;

        $cursorFactory = $this->getTesteeInstance(
            cursorBuilder: $cursorBuilder,
            outputConfig: $outputConfig,
        );

        self::assertInstanceOf(ConsoleCursorFactory::class, $cursorFactory);

        $cursor = $cursorFactory->create();

        self::assertSame($cursorStub, $cursor);
    }

    protected function getCursorStub(): Stub&IConsoleCursor
    {
        return $this->createStub(IConsoleCursor::class);
    }
}
