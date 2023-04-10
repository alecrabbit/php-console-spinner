<?php

declare(strict_types=1);

namespace AlecRabbit\Tests\Unit\Spinner\Core\Factory;

use AlecRabbit\Spinner\Contract\Output\IBufferedOutput;
use AlecRabbit\Spinner\Contract\Output\IResourceStream;
use AlecRabbit\Spinner\Core\Contract\IBufferedOutputBuilder;
use AlecRabbit\Spinner\Core\Factory\BufferedOutputFactory;
use AlecRabbit\Spinner\Core\Factory\Contract\IBufferedOutputFactory;
use AlecRabbit\Spinner\Core\Frame;
use AlecRabbit\Tests\TestCase\TestCaseWithPrebuiltMocksAndStubs;
use PHPUnit\Framework\Attributes\Test;
use Symfony\Component\Console\Output\BufferedOutput;

final class BufferedOutputFactoryTest extends TestCaseWithPrebuiltMocksAndStubs
{
    #[Test]
    public function canBeCreated(): void
    {
        $bufferedOutputFactory = $this->getTesteeInstance();

        self::assertInstanceOf(BufferedOutputFactory::class, $bufferedOutputFactory);
    }

    public function getTesteeInstance(
        ?IBufferedOutputBuilder $bufferedOutputBuilder = null,
        ?IResourceStream $resourceStream = null,
    ): IBufferedOutputFactory {
        return
            new BufferedOutputFactory(
                bufferedOutputBuilder: $bufferedOutputBuilder ?? $this->getBufferedOutputBuilderMock(),
                resourceStream: $resourceStream ?? $this->getResourceStreamMock(),
            );
    }

    #[Test]
    public function canCreate(): void
    {
        $bufferedOutputFactory = $this->getTesteeInstance();

        self::assertInstanceOf(BufferedOutputFactory::class, $bufferedOutputFactory);
        self::assertInstanceOf(IBufferedOutput::class, $bufferedOutputFactory->create());
    }

}
