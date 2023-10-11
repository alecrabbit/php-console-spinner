<?php

declare(strict_types=1);

namespace AlecRabbit\Tests\Unit\Spinner\Core\Factory;

use AlecRabbit\Spinner\Contract\Mode\CursorVisibilityMode;
use AlecRabbit\Spinner\Core\Builder\Contract\IConsoleCursorBuilder;
use AlecRabbit\Spinner\Core\Config\Contract\IOutputConfig;
use AlecRabbit\Spinner\Core\Factory\ConsoleCursorFactory;
use AlecRabbit\Spinner\Core\Factory\Contract\IBufferedOutputSingletonFactory;
use AlecRabbit\Spinner\Core\Factory\Contract\IConsoleCursorFactory;
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
        ?IBufferedOutputSingletonFactory $bufferedOutputFactory = null,
        ?IConsoleCursorBuilder $cursorBuilder = null,
        ?IOutputConfig $outputConfig = null,
    ): IConsoleCursorFactory {
        return new ConsoleCursorFactory(
            bufferedOutputFactory: $bufferedOutputFactory ?? $this->getBufferedOutputFactoryMock(),
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
    public function canCreateOrRetrieve(): void
    {
        $cursorVisibilityMode = CursorVisibilityMode::HIDDEN;
        $outputConfig = $this->getOutputConfigMock($cursorVisibilityMode);

        $bufferedOutputFactory = $this->getBufferedOutputFactoryMock();

        $bufferedOutputFactory
            ->expects(self::once())
            ->method('getOutput')
        ;

        $cursorStub = $this->getCursorStub();

        $cursorBuilder = $this->getCursorBuilderMock();

        $cursorBuilder
            ->expects(self::once())
            ->method('withOutput')
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
            bufferedOutputFactory: $bufferedOutputFactory,
            cursorBuilder: $cursorBuilder,
            outputConfig: $outputConfig,
        );

        self::assertInstanceOf(ConsoleCursorFactory::class, $cursorFactory);

        $cursor = $cursorFactory->create();

        self::assertSame($cursorStub, $cursor);
    }
}
