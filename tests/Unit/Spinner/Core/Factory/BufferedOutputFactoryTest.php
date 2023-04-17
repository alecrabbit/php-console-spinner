<?php

declare(strict_types=1);

namespace AlecRabbit\Tests\Unit\Spinner\Core\Factory;

use AlecRabbit\Spinner\Contract\Output\IBufferedOutput;
use AlecRabbit\Spinner\Contract\Output\IResourceStream;
use AlecRabbit\Spinner\Core\Contract\IBufferedOutputBuilder;
use AlecRabbit\Spinner\Core\Factory\BufferedOutputSingletonFactory;
use AlecRabbit\Spinner\Core\Factory\Contract\IBufferedOutputSingletonFactory;
use AlecRabbit\Tests\TestCase\TestCaseWithPrebuiltMocksAndStubs;
use PHPUnit\Framework\Attributes\Test;

final class BufferedOutputFactoryTest extends TestCaseWithPrebuiltMocksAndStubs
{
    #[Test]
    public function canBeCreated(): void
    {
        $bufferedOutputFactory = $this->getTesteeInstance();

        self::assertInstanceOf(BufferedOutputSingletonFactory::class, $bufferedOutputFactory);
    }

    public function getTesteeInstance(
        ?IBufferedOutputBuilder $bufferedOutputBuilder = null,
        ?IResourceStream $resourceStream = null,
    ): IBufferedOutputSingletonFactory {
        return new BufferedOutputSingletonFactory(
            bufferedOutputBuilder: $bufferedOutputBuilder ?? $this->getBufferedOutputBuilderMock(),
            resourceStream: $resourceStream ?? $this->getResourceStreamMock(),
        );
    }

    #[Test]
    public function canCreateOrRetrieve(): void
    {
        $bufferedOutputFactory = $this->getTesteeInstance();

        self::assertInstanceOf(BufferedOutputSingletonFactory::class, $bufferedOutputFactory);

        $bufferedOutput = $bufferedOutputFactory->getOutput();

        self::assertInstanceOf(IBufferedOutput::class, $bufferedOutput);

        self::assertSame($bufferedOutput, $bufferedOutputFactory->getOutput());
        self::assertSame($bufferedOutput, $bufferedOutputFactory->getOutput());
    }
}
