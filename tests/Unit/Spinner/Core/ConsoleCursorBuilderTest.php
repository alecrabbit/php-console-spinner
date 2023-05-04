<?php

declare(strict_types=1);

namespace AlecRabbit\Tests\Unit\Spinner\Core;

use AlecRabbit\Spinner\Contract\Option\OptionCursor;
use AlecRabbit\Spinner\Core\Builder\ConsoleCursorBuilder;
use AlecRabbit\Spinner\Core\Builder\Contract\IConsoleCursorBuilder;
use AlecRabbit\Spinner\Core\Output\ConsoleCursor;
use AlecRabbit\Tests\TestCase\TestCaseWithPrebuiltMocksAndStubs;
use PHPUnit\Framework\Attributes\Test;

final class ConsoleCursorBuilderTest extends TestCaseWithPrebuiltMocksAndStubs
{
    #[Test]
    public function canBeCreated(): void
    {
        $consoleCursorBuilder = $this->getTesteeInstance();

        self::assertInstanceOf(ConsoleCursorBuilder::class, $consoleCursorBuilder);
    }

    public function getTesteeInstance(): IConsoleCursorBuilder
    {
        return new ConsoleCursorBuilder();
    }

    #[Test]
    public function canBuild(): void
    {
        $output = $this->getBufferedOutputMock();
        $consoleCursorBuilder = $this->getTesteeInstance();
        $cursorOption = OptionCursor::VISIBLE;
        $consoleCursor =
            $consoleCursorBuilder
                ->withOutput($output)
                ->withOptionCursor($cursorOption)
                ->build()
        ;
        self::assertInstanceOf(ConsoleCursor::class, $consoleCursor);
        self::assertSame($output, self::getPropertyValue('output', $consoleCursor));
        self::assertSame($cursorOption, self::getPropertyValue('optionCursor', $consoleCursor));
    }
}
