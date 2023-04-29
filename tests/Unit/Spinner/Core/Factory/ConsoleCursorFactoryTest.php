<?php

declare(strict_types=1);

namespace AlecRabbit\Tests\Unit\Spinner\Core\Factory;

use AlecRabbit\Spinner\Contract\Option\OptionCursor;
use AlecRabbit\Spinner\Core\Contract\IConsoleCursorBuilder;
use AlecRabbit\Spinner\Core\Factory\ConsoleCursorFactory;
use AlecRabbit\Spinner\Core\Factory\Contract\IBufferedOutputSingletonFactory;
use AlecRabbit\Spinner\Core\Factory\Contract\IConsoleCursorFactory;
use AlecRabbit\Tests\TestCase\TestCaseWithPrebuiltMocksAndStubs;
use PHPUnit\Framework\Attributes\Test;

final class ConsoleCursorFactoryTest extends TestCaseWithPrebuiltMocksAndStubs
{
    #[Test]
    public function canBeCreated(): void
    {
        $cursorFactory = $this->getTesteeInstance();

        self::assertInstanceOf(ConsoleCursorFactory::class, $cursorFactory);
    }

    public function getTesteeInstance(
        ?IBufferedOutputSingletonFactory $bufferedOutputFactory = null,
        ?IConsoleCursorBuilder $cursorBuilder = null,
        ?OptionCursor $optionCursor = null,
    ): IConsoleCursorFactory {
        return new ConsoleCursorFactory(
            bufferedOutputFactory: $bufferedOutputFactory ?? $this->getBufferedOutputFactoryMock(),
            cursorBuilder: $cursorBuilder ?? $this->getCursorBuilderMock(),
            optionCursor: $optionCursor ?? OptionCursor::VISIBLE,
        );
    }

    #[Test]
    public function canCreateOrRetrieve(): void
    {
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
            ->method('withOptionCursor')
            ->willReturnSelf()
        ;

        $cursorBuilder
            ->expects(self::once())
            ->method('build')
            ->willReturn($cursorStub)
        ;

        $cursorFactory = $this->getTesteeInstance(
            bufferedOutputFactory: $bufferedOutputFactory,
            cursorBuilder: $cursorBuilder
        );

        self::assertInstanceOf(ConsoleCursorFactory::class, $cursorFactory);

        $cursor = $cursorFactory->create();

        self::assertSame($cursorStub, $cursor);
    }
}