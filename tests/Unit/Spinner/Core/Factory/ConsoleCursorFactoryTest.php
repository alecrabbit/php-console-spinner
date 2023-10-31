<?php

declare(strict_types=1);

namespace AlecRabbit\Tests\Unit\Spinner\Core\Factory;

use AlecRabbit\Spinner\Contract\Mode\CursorVisibilityMode;
use AlecRabbit\Spinner\Core\Builder\Contract\IConsoleCursorBuilder;
use AlecRabbit\Spinner\Core\Config\Contract\IOutputConfig;
use AlecRabbit\Spinner\Core\Factory\ConsoleCursorFactory;
use AlecRabbit\Spinner\Core\Factory\Contract\IConsoleCursorFactory;
use AlecRabbit\Spinner\Core\Output\Contract\IBuffer;
use AlecRabbit\Tests\TestCase\TestCaseWithPrebuiltMocksAndStubs;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\MockObject\MockObject;

final class ConsoleCursorFactoryTest extends TestCaseWithPrebuiltMocksAndStubs
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

    private function getOutputConfigMock(?CursorVisibilityMode $cursorVisibilityMode = null): MockObject&IOutputConfig
    {
        return $this->createConfiguredMock(
            IOutputConfig::class,
            [
                'getCursorVisibilityMode' => $cursorVisibilityMode ?? CursorVisibilityMode::VISIBLE,
            ]
        );
    }

    #[Test]
    public function canCreate(): void
    {
        $cursorVisibilityMode = CursorVisibilityMode::HIDDEN;
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
            ->method('withCursorVisibilityMode')
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

    private function getBufferMock(): MockObject&IBuffer
    {
        return $this->createMock(IBuffer::class);
    }
}
