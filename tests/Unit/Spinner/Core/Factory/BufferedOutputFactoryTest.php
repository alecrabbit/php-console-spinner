<?php

declare(strict_types=1);

namespace AlecRabbit\Tests\Unit\Spinner\Core\Factory;

use AlecRabbit\Spinner\Contract\Output\IBufferedOutput;
use AlecRabbit\Spinner\Contract\Output\IResourceStream;
use AlecRabbit\Spinner\Core\Builder\Contract\IBufferedOutputBuilder;
use AlecRabbit\Spinner\Core\Factory\BufferedOutputFactory;
use AlecRabbit\Spinner\Core\Factory\Contract\IBufferedOutputFactory;
use AlecRabbit\Tests\TestCase\TestCaseWithPrebuiltMocksAndStubs;
use PHPUnit\Framework\Attributes\Test;

final class BufferedOutputFactoryTest extends TestCaseWithPrebuiltMocksAndStubs
{
    #[Test]
    public function canBeInstantiated(): void
    {
        $bufferedOutputFactory = $this->getTesteeInstance();

        self::assertInstanceOf(BufferedOutputFactory::class, $bufferedOutputFactory);
    }

    public function getTesteeInstance(
        ?IBufferedOutputBuilder $bufferedOutputBuilder = null,
        ?IResourceStream $resourceStream = null,
    ): IBufferedOutputFactory {
        return new BufferedOutputFactory(
            bufferedOutputBuilder: $bufferedOutputBuilder ?? $this->getBufferedOutputBuilderMock(),
            resourceStream: $resourceStream ?? $this->getResourceStreamMock(),
        );
    }

    #[Test]
    public function canCreateOrRetrieve(): void
    {
        $bufferedOutputFactory = $this->getTesteeInstance();

        self::assertInstanceOf(BufferedOutputFactory::class, $bufferedOutputFactory);

        $bufferedOutput = $bufferedOutputFactory->create();

        self::assertInstanceOf(IBufferedOutput::class, $bufferedOutput);

        self::assertSame($bufferedOutput, $bufferedOutputFactory->create());
        self::assertSame($bufferedOutput, $bufferedOutputFactory->create());
    }
}
