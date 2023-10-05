<?php

declare(strict_types=1);

namespace AlecRabbit\Tests\Unit\Spinner\Asynchronous\Factory;

use AlecRabbit\Spinner\Core\Contract\Loop\A\ALoopAdapter;
use AlecRabbit\Spinner\Core\Contract\Loop\A\ALoopProbe;
use AlecRabbit\Spinner\Core\Contract\Loop\Contract\ILoop;
use AlecRabbit\Spinner\Core\Factory\Contract\ILoopAutoStarterFactory;
use AlecRabbit\Spinner\Core\Factory\Contract\ILoopFactory;
use AlecRabbit\Spinner\Core\Factory\Contract\ILoopProbeFactory;
use AlecRabbit\Spinner\Core\Factory\LoopFactory;
use AlecRabbit\Tests\TestCase\TestCaseWithPrebuiltMocksAndStubs;
use AlecRabbit\Tests\Unit\Spinner\Asynchronous\Override\ALoopAdapterOverride;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\MockObject\MockObject;

final class LoopFactoryTest extends TestCaseWithPrebuiltMocksAndStubs
{

    #[Test]
    public function canBeInstantiated(): void
    {
        $loopFactory = $this->getTesteeInstance();

        self::assertInstanceOf(LoopFactory::class, $loopFactory);
    }

    public function getTesteeInstance(
        ?ILoopProbeFactory $loopProbeFactory = null,
        ?ILoopAutoStarterFactory $loopAutoStarterFactory = null,
    ): ILoopFactory {
        return new LoopFactory(
            loopProbeFactory: $loopProbeFactory ?? $this->getLoopProbeFactoryMock(),
            loopAutoStarterFactory: $loopAutoStarterFactory ?? $this->getLoopAutoStarterFactoryMock(),
        );
    }

    protected function getLoopProbeFactoryMock(): MockObject&ILoopProbeFactory
    {
        $loopProbeFactory = parent::getLoopProbeFactoryMock();
        $loopProbeFactory->method('createProbe')
            ->willReturn(
                new class() extends ALoopProbe {
                    public static function isSupported(): bool
                    {
                        return true;
                    }

                    /**
                     * @deprecated
                     */
                    public function createLoop(): ILoop
                    {
                        return new ALoopAdapterOverride();
                    }
                }
            )
        ;
        return $loopProbeFactory;
    }

    #[Test]
    public function canGetLoopAdapter(): void
    {
        $loopFactory = $this->getTesteeInstance();

        self::assertInstanceOf(ALoopAdapter::class, $loopFactory->getLoop());
    }

    protected function setUp(): void
    {
        self::setPropertyValue(LoopFactory::class, 'loop', null);
    }
}
