<?php

declare(strict_types=1);

namespace AlecRabbit\Tests\Unit\Spinner\Core;

use AlecRabbit\Spinner\Contract\Mode\CursorVisibilityMode;
use AlecRabbit\Spinner\Core\Builder\ConsoleCursorBuilder;
use AlecRabbit\Spinner\Core\Builder\Contract\IConsoleCursorBuilder;
use AlecRabbit\Spinner\Core\Output\ConsoleCursor;
use AlecRabbit\Tests\TestCase\TestCaseWithPrebuiltMocksAndStubs;
use PHPUnit\Framework\Attributes\Test;

final class ConsoleCursorBuilderTest extends TestCaseWithPrebuiltMocksAndStubs
{
    #[Test]
    public function canBeInstantiated(): void
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
        $cursorMode = CursorVisibilityMode::VISIBLE;
        $consoleCursor =
            $consoleCursorBuilder
                ->withOutput($output)
                ->withCursorVisibilityMode($cursorMode)
                ->build()
        ;
        self::assertInstanceOf(ConsoleCursor::class, $consoleCursor);
        self::assertSame($output, self::getPropertyValue('output', $consoleCursor));
        self::assertSame($cursorMode, self::getPropertyValue('cursorVisibilityMode', $consoleCursor));
    }
}
