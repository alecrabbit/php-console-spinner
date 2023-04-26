<?php

declare(strict_types=1);

namespace AlecRabbit\Tests\Unit\Spinner\Core;

use AlecRabbit\Spinner\Core\Contract\IDriverOutputBuilder;
use AlecRabbit\Spinner\Core\DriverOutputBuilder;
use AlecRabbit\Spinner\Core\Output\DriverOutput;
use AlecRabbit\Spinner\Exception\LogicException;
use AlecRabbit\Tests\TestCase\TestCaseWithPrebuiltMocksAndStubs;
use PHPUnit\Framework\Attributes\Test;

final class DriverOutputBuilderTest extends TestCaseWithPrebuiltMocksAndStubs
{
    #[Test]
    public function canBeCreated(): void
    {
        $outputBuilder = $this->getTesteeInstance();

        self::assertInstanceOf(DriverOutputBuilder::class, $outputBuilder);
    }

    public function getTesteeInstance(): IDriverOutputBuilder
    {
        return new DriverOutputBuilder();
    }

    #[Test]
    public function canBuild(): void
    {
        $outputBuilder = $this->getTesteeInstance();

        $output =
            $outputBuilder
                ->withOutput($this->getBufferedOutputMock())
                ->withCursor($this->getCursorMock())
                ->build()
        ;

        self::assertInstanceOf(DriverOutput::class, $output);
    }

    #[Test]
    public function throwsIfCursorIsNotSet(): void
    {
        $exceptionClass = LogicException::class;
        $exceptionMessage = 'Cursor is not set.';

        $test = function (): void {
            $outputBuilder = $this->getTesteeInstance();

            $outputBuilder
                ->withOutput($this->getBufferedOutputMock())
                ->build()
            ;
        };

        $this->wrapExceptionTest(
            test: $test,
            exceptionOrExceptionClass: $exceptionClass,
            exceptionMessage: $exceptionMessage,
        );
    }

    #[Test]
    public function throwsIfOutputIsNotSet(): void
    {
        $test = function (): void {
            $outputBuilder = $this->getTesteeInstance();

            $outputBuilder
                ->withCursor($this->getCursorMock())
                ->build()
            ;
        };

        $this->wrapExceptionTest(
            $test,
            LogicException::class,
            'Output is not set.',
        );
    }
}
