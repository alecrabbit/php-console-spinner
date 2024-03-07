<?php

declare(strict_types=1);

namespace AlecRabbit\Tests\Lib\Unit\Spinner\Core\Factory;

use AlecRabbit\Lib\Spinner\Contract\ILoopInfoFormatter;
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
        ?IOutput $output = null,
        ?ILoopInfoFormatter $loopInfoFormatter = null,
    ): ILoopProviderFactory {
        return new DecoratedLoopProviderFactory(
            loopProviderFactory: $loopProviderFactory ?? $this->getLoopProviderFactoryMock(),
            output: $output ?? $this->getOutputMock(),
            loopInfoFormatter: $loopInfoFormatter ?? $this->getLoopInfoFormatterMock(),
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

    private function getLoopInfoFormatterMock(): MockObject&ILoopInfoFormatter
    {
        return $this->createMock(ILoopInfoFormatter::class);
    }

    #[Test]
    public function canCreateWithoutLoop(): void
    {
        $loopProviderFactory = $this->getLoopProviderFactoryMock();
        $output = $this->getOutputMock();
        $loopInfoFormatter = $this->getLoopInfoFormatterMock();

        $provider = $this->getTesteeInstance(
            loopProviderFactory: $loopProviderFactory,
            output: $output,
            loopInfoFormatter: $loopInfoFormatter
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

        $str = 'None';

        $loopInfoFormatter
            ->expects($this->once())
            ->method('format')
            ->with(null)
            ->willReturn($str)
        ;

        $output
            ->expects($this->once())
            ->method('writeln')
            ->with($str)
        ;

        $actual = $provider->__invoke();

        self::assertSame($loopProvider, $actual);
    }

    #[Test]
    public function canCreateWithLoop(): void
    {
        $loop = $this->createMock(ILoop::class);
        $loopProviderFactory = $this->getLoopProviderFactoryMock();
        $output = $this->getOutputMock();
        $loopInfoFormatter = $this->getLoopInfoFormatterMock();

        $provider = $this->getTesteeInstance(
            loopProviderFactory: $loopProviderFactory,
            output: $output,
            loopInfoFormatter: $loopInfoFormatter
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

        $str = 'Using loop: ' . $loop::class;

        $loopInfoFormatter
            ->expects($this->once())
            ->method('format')
            ->with($loop)
            ->willReturn($str)
        ;

        $output
            ->expects($this->once())
            ->method('writeln')
            ->with($str)
        ;

        $actual = $provider->create();

        self::assertSame($loopProvider, $actual);
    }
}
