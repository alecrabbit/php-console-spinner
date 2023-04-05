<?php

declare(strict_types=1);

namespace AlecRabbit\Tests\Unit\Spinner\Asynchronous\Factory;

use AlecRabbit\Spinner\Core\Factory\Contract\ILoopFactory;
use AlecRabbit\Spinner\Core\Factory\LoopFactory;
use AlecRabbit\Spinner\Core\Loop\A\ALoop;
use AlecRabbit\Spinner\Core\Loop\A\ALoopProbe;
use AlecRabbit\Spinner\Core\Loop\Contract\ILoop;
use AlecRabbit\Spinner\Core\Loop\Contract\ILoopProbeFactory;
use AlecRabbit\Tests\TestCase\TestCaseWithPrebuiltMocks;
use AlecRabbit\Tests\Unit\Spinner\Asynchronous\Override\ALoopAdapterOverride;
use PHPUnit\Framework\Attributes\Test;

final class LoopFactoryTest extends TestCaseWithPrebuiltMocks
{
    #[Test]
    public function canBeCreated(): void
    {
        $loopFactory = $this->getTesteeInstance();

        self::assertInstanceOf(LoopFactory::class, $loopFactory);
    }


    public function getTesteeInstance(
        ?ILoopProbeFactory $loopProbeFactory = null
    ): ILoopFactory {
        return
            new LoopFactory(
                loopProbeFactory: $loopProbeFactory ?? $this->getLoopProbeFactoryMock(),
            );
    }

    #[Test]
    public function canGetLoopAdapter(): void
    {
        $loopProbeFactory = $this->getLoopProbeFactoryMock();
        $loopProbeFactory->method('getProbe')
            ->willReturn(
                new class() extends ALoopProbe {
                    public static function isSupported(): bool
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

        $loopFactory = $this->getTesteeInstance(loopProbeFactory: $loopProbeFactory);

        self::assertInstanceOf(ALoop::class, $loopFactory->getLoop());
    }

}
