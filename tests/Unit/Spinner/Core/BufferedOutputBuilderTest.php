<?php

declare(strict_types=1);

namespace AlecRabbit\Tests\Unit\Spinner\Core;

use AlecRabbit\Spinner\Contract\Output\IBufferedOutput;
use AlecRabbit\Spinner\Contract\Output\IOutput;
use AlecRabbit\Spinner\Core\Builder\BufferedOutputBuilder;
use AlecRabbit\Spinner\Core\Builder\Contract\IBufferedOutputBuilder;
use AlecRabbit\Spinner\Exception\LogicException;
use AlecRabbit\Tests\TestCase\TestCaseWithPrebuiltMocksAndStubs;
use PHPUnit\Framework\Attributes\Test;

final class BufferedOutputBuilderTest extends TestCaseWithPrebuiltMocksAndStubs
{
    #[Test]
    public function canBeCreated(): void
    {
        $outputBuilder = $this->getTesteeInstance();

        self::assertInstanceOf(BufferedOutputBuilder::class, $outputBuilder);
    }

    public function getTesteeInstance(): IBufferedOutputBuilder
    {
        return new BufferedOutputBuilder();
    }

    #[Test]
    public function canBuildOutput(): void
    {
        $bufferedOutputBuilder = $this->getTesteeInstance();

        $bufferedOutput =
            $bufferedOutputBuilder
                ->withStream($this->getResourceStreamMock())
                ->build()
        ;

        self::assertTrue(is_subclass_of($bufferedOutput, IOutput::class));
        self::assertTrue(is_subclass_of($bufferedOutput, IBufferedOutput::class));
    }

    #[Test]
    public function throwsIfAuxConfigIsNotSet(): void
    {
        $exceptionClass = LogicException::class;
        $exceptionMessage = 'Stream is not set.';
        $this->expectException($exceptionClass);
        $this->expectExceptionMessage($exceptionMessage);

        $outputBuilder = $this->getTesteeInstance();
        $outputBuilder->build();

        self::fail(self::exceptionNotThrownString($exceptionClass, $exceptionMessage));
    }
}
