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
        return
            new DriverOutputBuilder();
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

        $test = function () {
            $outputBuilder = $this->getTesteeInstance();

            $outputBuilder
                ->withOutput($this->getBufferedOutputMock())
                ->build()
            ;
        };

        $this->testExceptionWrapper(
            exceptionClass: $exceptionClass,
            exceptionMessage: $exceptionMessage,
            test: $test,
            method: __METHOD__,
        );
    }

    #[Test]
    public function throwsIfOutputIsNotSet(): void
    {
        $test = function () {
            $outputBuilder = $this->getTesteeInstance();

            $outputBuilder
                ->withCursor($this->getCursorMock())
                ->build()
            ;
        };

        $this->testExceptionWrapper(
            LogicException::class,
            'Output is not set.',
            $test,
            method: __METHOD__,
        );
    }
}
