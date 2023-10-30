<?php

declare(strict_types=1);

namespace AlecRabbit\Tests\Unit\Spinner\Core\Factory;

use AlecRabbit\Spinner\Contract\Output\IBufferedOutput;
use AlecRabbit\Spinner\Core\Builder\Contract\IDriverOutputBuilder;
use AlecRabbit\Spinner\Core\Factory\Contract\IConsoleCursorFactory;
use AlecRabbit\Spinner\Core\Factory\Contract\IDriverOutputFactory;
use AlecRabbit\Spinner\Core\Factory\DriverOutputFactory;
use AlecRabbit\Tests\TestCase\TestCaseWithPrebuiltMocksAndStubs;
use PHPUnit\Framework\Attributes\Test;

final class DriverOutputFactoryTest extends TestCaseWithPrebuiltMocksAndStubs
{
    #[Test]
    public function canBeInstantiated(): void
    {
        $driverOutputFactory = $this->getTesteeInstance();

        self::assertInstanceOf(DriverOutputFactory::class, $driverOutputFactory);
    }

    public function getTesteeInstance(
        ?IDriverOutputBuilder $driverOutputBuilder = null,
        ?IBufferedOutput $bufferedOutput = null,
        ?IConsoleCursorFactory $cursorFactory = null,
    ): IDriverOutputFactory {
        return new DriverOutputFactory(
            driverOutputBuilder: $driverOutputBuilder ?? $this->getDriverOutputBuilderMock(),
            bufferedOutput: $bufferedOutput ?? $this->getBufferedOutputMock(),
            cursorFactory: $cursorFactory ?? $this->getCursorFactoryMock(),
        );
    }

    #[Test]
    public function canCreate(): void
    {
        $driverOutputBuilder = $this->getDriverOutputBuilderMock();
        $driverOutputBuilder
            ->expects(self::once())
            ->method('withOutput')
            ->willReturnSelf()
        ;
        $driverOutputBuilder
            ->expects(self::once())
            ->method('withCursor')
            ->willReturnSelf()
        ;
        $driverOutputStub = $this->getDriverOutputStub();
        $driverOutputBuilder
            ->expects(self::once())
            ->method('build')
            ->willReturn($driverOutputStub)
        ;

        $cursorFactory = $this->getCursorFactoryMock();

        $cursorFactory
            ->expects(self::once())
            ->method('create')
        ;

        $driverOutputFactory = $this->getTesteeInstance(
            driverOutputBuilder: $driverOutputBuilder,
            cursorFactory: $cursorFactory,
        );

        self::assertSame($driverOutputStub, $driverOutputFactory->create());
    }
}
