<?php

declare(strict_types=1);

namespace AlecRabbit\Tests\Lib\Unit\Spinner\Core\Factory;

use AlecRabbit\Lib\Spinner\Contract\ILoopInfoPrinter;
use AlecRabbit\Lib\Spinner\Core\Factory\DecoratedLoopProviderFactory;
use AlecRabbit\Spinner\Contract\Output\IOutput;
use AlecRabbit\Spinner\Core\Factory\Contract\ILoopProviderFactory;
use AlecRabbit\Spinner\Core\Loop\Contract\ILoop;
use AlecRabbit\Spinner\Core\Loop\Contract\ILoopProvider;
use AlecRabbit\Tests\TestCase\TestCase;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\MockObject\MockObject;

final class DecoratedLoopProviderFactoryTest extends TestCase
{
    #[Test]
    public function canBeInstantiated(): void
    {
        $provider = $this->getTesteeInstance();

        self::assertInstanceOf(DecoratedLoopProviderFactory::class, $provider);
    }

    private function getTesteeInstance(
        ?ILoopProviderFactory $loopProviderFactory = null,
        ?ILoopInfoPrinter $loopInfoPrinter = null,
    ): ILoopProviderFactory {
        return new DecoratedLoopProviderFactory(
            loopProviderFactory: $loopProviderFactory ?? $this->getLoopProviderFactoryMock(),
            loopInfoPrinter: $loopInfoPrinter ?? $this->getLoopInfoPrinterMock(),
        );
    }

    private function getLoopProviderFactoryMock(): MockObject&ILoopProviderFactory
    {
        return $this->createMock(ILoopProviderFactory::class);
    }

    private function getOutputMock(): MockObject&IOutput
    {
        return $this->createMock(IOutput::class);
    }

    private function getLoopInfoPrinterMock(): MockObject&ILoopInfoPrinter
    {
        return $this->createMock(ILoopInfoPrinter::class);
    }

    #[Test]
    public function canCreateWithoutLoop(): void
    {
        $loopProviderFactory = $this->getLoopProviderFactoryMock();
        $loopInfoPrinter = $this->getLoopInfoPrinterMock();

        $provider = $this->getTesteeInstance(
            loopProviderFactory: $loopProviderFactory,
            loopInfoPrinter: $loopInfoPrinter
        );
        $loopProvider = $this->createMock(ILoopProvider::class);

        $loopProviderFactory
            ->expects($this->once())
            ->method('create')
            ->willReturn($loopProvider)
        ;

        $loopProvider
            ->expects($this->once())
            ->method('hasLoop')
            ->willReturn(false)
        ;

        $loopProvider
            ->expects($this->never())
            ->method('getLoop')
        ;

        $loopInfoPrinter
            ->expects($this->once())
            ->method('print')
            ->with(null)
        ;

        $actual = $provider->__invoke();

        self::assertSame($loopProvider, $actual);
    }

    #[Test]
    public function canCreateWithLoop(): void
    {
        $loop = $this->createMock(ILoop::class);
        $loopProviderFactory = $this->getLoopProviderFactoryMock();
        $loopInfoPrinter = $this->getLoopInfoPrinterMock();

        $provider = $this->getTesteeInstance(
            loopProviderFactory: $loopProviderFactory,
            loopInfoPrinter: $loopInfoPrinter
        );
        $loopProvider = $this->createMock(ILoopProvider::class);

        $loopProviderFactory
            ->expects($this->once())
            ->method('create')
            ->willReturn($loopProvider)
        ;

        $loopProvider
            ->expects($this->once())
            ->method('hasLoop')
            ->willReturn(true)
        ;

        $loopProvider
            ->expects($this->once())
            ->method('getLoop')
            ->willReturn($loop)
        ;

        $loopInfoPrinter
            ->expects($this->once())
            ->method('print')
            ->with($loop)
        ;

        $actual = $provider->create();

        self::assertSame($loopProvider, $actual);
    }
}
