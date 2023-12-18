<?php

declare(strict_types=1);

namespace AlecRabbit\Tests\Spinner\Unit\Core\Output\Factory;

use AlecRabbit\Spinner\Core\Config\Contract\IOutputConfig;
use AlecRabbit\Spinner\Core\Output\Contract\Factory\IWritableStreamFactory;
use AlecRabbit\Spinner\Core\Output\Factory\WritableStreamFactory;
use AlecRabbit\Spinner\Core\Output\WritableStream;
use AlecRabbit\Tests\TestCase\TestCase;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\MockObject\MockObject;

final class WritableStreamFactoryTest extends TestCase
{
    #[Test]
    public function canBeInstantiated(): void
    {
        $factory = $this->getTesteeInstance();
        self::assertInstanceOf(WritableStreamFactory::class, $factory);
    }

    public function getTesteeInstance(
        ?IOutputConfig $outputConfig = null,
    ): IWritableStreamFactory {
        return
            new WritableStreamFactory(
                outputConfig: $outputConfig ?? $this->getOutputConfigMock(),
            );
    }

    protected function getOutputConfigMock(): MockObject&IOutputConfig
    {
        return $this->createMock(IOutputConfig::class);
    }

    #[Test]
    public function canCreate(): void
    {
        $outputConfig = $this->getOutputConfigMock();
        $outputConfig
            ->expects(self::once())
            ->method('getStream')
            ->willReturn(STDOUT)
        ;
        $factory = $this->getTesteeInstance(
            outputConfig: $outputConfig,
        );

        $result = $factory->create();

        self::assertInstanceOf(WritableStream::class, $result);
    }

}
