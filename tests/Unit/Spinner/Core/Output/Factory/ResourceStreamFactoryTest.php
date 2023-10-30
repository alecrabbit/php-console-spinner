<?php

declare(strict_types=1);

namespace AlecRabbit\Tests\Unit\Spinner\Core\Output\Factory;

use AlecRabbit\Spinner\Core\Config\Contract\IOutputConfig;
use AlecRabbit\Spinner\Core\Output\Contract\Factory\IResourceStreamFactory;
use AlecRabbit\Spinner\Core\Output\Factory\ResourceStreamFactory;
use AlecRabbit\Spinner\Core\Output\ResourceStream;
use AlecRabbit\Tests\TestCase\TestCase;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\MockObject\MockObject;

final class ResourceStreamFactoryTest extends TestCase
{
    #[Test]
    public function canBeInstantiated(): void
    {
        $factory = $this->getTesteeInstance();
        self::assertInstanceOf(ResourceStreamFactory::class, $factory);
    }

    public function getTesteeInstance(
        ?IOutputConfig $outputConfig = null,
    ): IResourceStreamFactory {
        return
            new ResourceStreamFactory(
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

        self::assertInstanceOf(ResourceStream::class, $result);
    }

}
