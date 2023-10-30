<?php

declare(strict_types=1);

namespace AlecRabbit\Tests\Unit\Spinner\Core\Factory;

use AlecRabbit\Spinner\Contract\Output\IBufferedOutput;
use AlecRabbit\Spinner\Contract\Output\IResourceStream;
use AlecRabbit\Spinner\Core\Builder\Contract\IBufferedOutputBuilder;
use AlecRabbit\Spinner\Core\Factory\BufferedOutputFactory;
use AlecRabbit\Spinner\Core\Factory\Contract\IBufferedOutputFactory;
use AlecRabbit\Spinner\Core\Output\Contract\IBuffer;
use AlecRabbit\Tests\TestCase\TestCaseWithPrebuiltMocksAndStubs;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\MockObject\MockObject;

final class BufferedOutputFactoryTest extends TestCaseWithPrebuiltMocksAndStubs
{
    #[Test]
    public function canBeInstantiated(): void
    {
        $bufferedOutputFactory = $this->getTesteeInstance();

        self::assertInstanceOf(BufferedOutputFactory::class, $bufferedOutputFactory);
    }

    public function getTesteeInstance(
        ?IResourceStream $resourceStream = null,
        ?IBuffer $buffer = null,
    ): IBufferedOutputFactory {
        return new BufferedOutputFactory(
            resourceStream: $resourceStream ?? $this->getResourceStreamMock(),
            buffer: $buffer ?? $this->getBufferMock(),
        );
    }

    #[Test]
    public function canCreate(): void
    {
        $bufferedOutputFactory = $this->getTesteeInstance();

        self::assertInstanceOf(BufferedOutputFactory::class, $bufferedOutputFactory);

        $bufferedOutput = $bufferedOutputFactory->create();

        self::assertInstanceOf(IBufferedOutput::class, $bufferedOutput);
    }

    private function getBufferMock(): MockObject&IBuffer
    {
        return $this->createMock(IBuffer::class);
    }
}
