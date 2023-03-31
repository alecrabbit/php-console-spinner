<?php

declare(strict_types=1);

namespace AlecRabbit\Tests\Spinner\Unit\Spinner\Asynchronous\Factory;

use AlecRabbit\Spinner\Container\Contract\IContainer;
use AlecRabbit\Spinner\Core\A\ALoopAdapter;
use AlecRabbit\Spinner\Core\Contract\ILoopAdapter;
use AlecRabbit\Spinner\Core\Contract\ILoopProbeFactory;
use AlecRabbit\Spinner\Core\Factory\Contract\ILoopFactory;
use AlecRabbit\Spinner\Core\Factory\LoopFactory;
use AlecRabbit\Spinner\Core\Loop\A\ALoopProbe;
use AlecRabbit\Tests\Spinner\TestCase\TestCaseWithPrebuiltMocks;
use AlecRabbit\Tests\Spinner\Unit\Spinner\Asynchronous\Override\ALoopAdapterOverride;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\MockObject\MockObject;

final class LoopFactoryTest extends TestCaseWithPrebuiltMocks
{
    #[Test]
    public function canBeCreated(): void
    {
        $loopFactory = $this->getTesteeInstance(container: null, loopProbeFactory: null);

        self::assertInstanceOf(LoopFactory::class, $loopFactory);
    }


    public function getTesteeInstance(
        (MockObject&IContainer)|null $container,
        (MockObject&ILoopProbeFactory)|null $loopProbeFactory,
    ): ILoopFactory {
        return
            new LoopFactory(
                container: $container ?? $this->getContainerMock(),
            );
    }

    #[Test]
    public function canGetLoopAdapter(): void
    {
        $container = $this->getContainerMock();

        $loopProbeFactory = $this->getLoopProbeFactoryMock();
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
            ->willReturn($loopProbeFactory)
        ;

        $loopFactory = $this->getTesteeInstance(container: $container, loopProbeFactory: $loopProbeFactory);

        self::assertInstanceOf(ALoopAdapter::class, $loopFactory->getLoop());
    }

}
