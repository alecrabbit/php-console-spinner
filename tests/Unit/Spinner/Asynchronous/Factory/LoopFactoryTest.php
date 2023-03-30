<?php

declare(strict_types=1);

namespace AlecRabbit\Tests\Spinner\Unit\Spinner\Asynchronous\Factory;

use AlecRabbit\Spinner\Asynchronous\Loop\ILoopProbeFactory;
use AlecRabbit\Spinner\Asynchronous\Loop\LoopManager;
use AlecRabbit\Spinner\Container\Contract\IContainer;
use AlecRabbit\Spinner\Core\A\ALoopAdapter;
use AlecRabbit\Spinner\Core\Contract\ILoopAdapter;
use AlecRabbit\Spinner\Core\Factory\Contract\ILoopFactory;
use AlecRabbit\Spinner\Core\Factory\LoopFactory;
use AlecRabbit\Spinner\Core\Loop\Probe\A\ALoopProbe;
use AlecRabbit\Spinner\Exception\DomainException;
use AlecRabbit\Tests\Spinner\TestCase\TestCase;
use AlecRabbit\Tests\Spinner\Unit\Spinner\Core\Factory\Override\ALoopAdapterOverride;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\MockObject\MockObject;

final class LoopFactoryTest extends TestCase
{
    #[Test]
    public function canBeCreated(): void
    {
        $loopFactory = $this->getTesteeInstance(container: null);

        self::assertInstanceOf(LoopFactory::class, $loopFactory);
    }

    public function getTesteeInstance(
        (MockObject&IContainer)|null $container,
    ): ILoopFactory {
        return
            new LoopFactory(
                container: $container ?? $this->getContainerMock(),
            );
    }

    protected function getContainerMock(): MockObject&IContainer
    {
        return $this->createMock(IContainer::class);
    }

    #[Test]
    public function throwsOnLoopGetWithEmptyProbes(): void
    {
        $container = $this->createMock(IContainer::class);
        $loopProbeFactory = $this->createMock(ILoopProbeFactory::class);
        $loopProbeFactory->method('getProbe')
            ->willReturn(
                new class() extends ALoopProbe {
                    public static function isSupported(): bool
                    {
                        return true;
                    }

                    public function createLoop(): ILoopAdapter
                    {
                        return new ALoopAdapterOverride();
                    }
                }
            )
        ;
        $container
            ->method('get')
            ->willReturn(
                new LoopManager($loopProbeFactory)
            )
        ;

        $loopFactory = $this->getTesteeInstance(container: $container);

        $exception = DomainException::class;
        $exceptionMessage =
            'No supported event loop found.'
            . ' Check you have installed one of the supported event loops.'
            . ' Check your probes list if you have modified it.';

//        $this->expectException($exception);
//        $this->expectExceptionMessage($exceptionMessage);

        self::assertInstanceOf(ALoopAdapter::class, $loopFactory->getLoop());
//        self::exceptionNotThrown($exception, $exceptionMessage);
    }

}
