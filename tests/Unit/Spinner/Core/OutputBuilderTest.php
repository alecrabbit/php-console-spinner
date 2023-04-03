<?php

declare(strict_types=1);

namespace AlecRabbit\Tests\Spinner\Unit\Spinner\Core;

use AlecRabbit\Spinner\Contract\IOutput;
use AlecRabbit\Spinner\Core\Contract\IOutputBuilder;
use AlecRabbit\Spinner\Core\OutputBuilder;
use AlecRabbit\Spinner\Exception\LogicException;
use AlecRabbit\Tests\Spinner\TestCase\TestCaseWithPrebuiltMocks;
use PHPUnit\Framework\Attributes\Test;

final class OutputBuilderTest extends TestCaseWithPrebuiltMocks
{
    #[Test]
    public function canBeCreated(): void
    {
        $outputBuilder = $this->getTesteeInstance();

        self::assertInstanceOf(OutputBuilder::class, $outputBuilder);
    }

    public function getTesteeInstance(): IOutputBuilder
    {
        return
            new OutputBuilder();
    }

    #[Test]
    public function canBuildOutput(): void
    {
        $outputBuilder = $this->getTesteeInstance();

        $output =
            $outputBuilder
                ->withStream(STDERR)
                ->build();

        self::assertTrue(is_subclass_of($output, IOutput::class));
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
