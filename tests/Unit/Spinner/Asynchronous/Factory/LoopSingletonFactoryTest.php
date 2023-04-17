<?php

declare(strict_types=1);

namespace AlecRabbit\Tests\Unit\Spinner\Asynchronous\Factory;

use AlecRabbit\Spinner\Core\Contract\Loop\A\ALoopAdapter;
use AlecRabbit\Spinner\Core\Contract\Loop\A\ALoopProbe;
use AlecRabbit\Spinner\Core\Contract\Loop\Contract\ILoop;
use AlecRabbit\Spinner\Core\Factory\Contract\ILoopProbeFactory;
use AlecRabbit\Spinner\Core\Factory\Contract\ILoopSingletonFactory;
use AlecRabbit\Spinner\Core\Factory\LoopSingletonFactory;
use AlecRabbit\Tests\TestCase\TestCaseWithPrebuiltMocksAndStubs;
use AlecRabbit\Tests\Unit\Spinner\Asynchronous\Override\ALoopAdapterOverride;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\MockObject\MockObject;

final class LoopSingletonFactoryTest extends TestCaseWithPrebuiltMocksAndStubs
{

    protected function setUp(): void
    {
        self::setPropertyValue(LoopSingletonFactory::class, 'loop', null);
    }
    #[Test]
    public function canBeCreated(): void
    {
        $loopFactory = $this->getTesteeInstance();

        self::assertInstanceOf(LoopSingletonFactory::class, $loopFactory);
    }

    public function getTesteeInstance(
        ?ILoopProbeFactory $loopProbeFactory = null,
    ): ILoopSingletonFactory {
        return new LoopSingletonFactory(
            loopProbeFactory: $loopProbeFactory ?? $this->getLoopProbeFactoryMock(),
        );
    }

    #[Test]
    public function canGetLoopAdapter(): void
    {
        $loopFactory = $this->getTesteeInstance();

        self::assertInstanceOf(ALoopAdapter::class, $loopFactory->getLoop());
    }

    protected function getLoopProbeFactoryMock(): MockObject&ILoopProbeFactory
    {
        $loopProbeFactory = parent::getLoopProbeFactoryMock();
        $loopProbeFactory->method('getProbe')
            ->willReturn(
                new class() extends ALoopProbe {
                    public static function isAvailable(): bool
                    {
                        return true;
                    }

                    public function createLoop(): ILoop
                    {
                        return new ALoopAdapterOverride();
                    }
                }
            )
        ;
        return $loopProbeFactory;
    }
}
