<?php

declare(strict_types=1);
// 03.04.23
namespace AlecRabbit\Tests\Spinner\Unit\Spinner\Core\Factory;

use AlecRabbit\Spinner\Core\Config\Contract\IDefaultsProvider;
use AlecRabbit\Spinner\Core\Config\IOutputFactory;
use AlecRabbit\Spinner\Core\Factory\OutputFactory;
use AlecRabbit\Spinner\Core\Output\StreamBufferedOutput;
use AlecRabbit\Tests\Spinner\TestCase\TestCaseWithPrebuiltMocks;
use PHPUnit\Framework\Attributes\Test;


final class OutputFactoryTest extends TestCaseWithPrebuiltMocks
{
    #[Test]
    public function canBeCreated(): void
    {
        $outputFactory = $this->getTesteeInstance();

        self::assertInstanceOf(OutputFactory::class, $outputFactory);
    }

    public function getTesteeInstance(?IDefaultsProvider $defaultsProvider = null): IOutputFactory
    {
        return
            new OutputFactory(
                defaultsProvider: $defaultsProvider ?? $this->getDefaultsProviderMock(),
            );
    }

    #[Test]
    public function canCreateOutput(): void
    {
        $outputFactory = $this->getTesteeInstance();

        self::assertInstanceOf(StreamBufferedOutput::class, $outputFactory->getOutput());
    }
}
