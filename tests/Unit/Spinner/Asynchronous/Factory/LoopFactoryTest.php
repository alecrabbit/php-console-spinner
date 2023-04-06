<?php

declare(strict_types=1);

namespace AlecRabbit\Tests\Unit\Spinner\Asynchronous\Factory;

use AlecRabbit\Spinner\Core\Config\Contract\ILoopConfig;
use AlecRabbit\Spinner\Core\Contract\ILoopSetupBuilder;
use AlecRabbit\Spinner\Core\Factory\Contract\ILoopFactory;
use AlecRabbit\Spinner\Core\Factory\Contract\ILoopProbeFactory;
use AlecRabbit\Spinner\Core\Factory\LoopFactory;
use AlecRabbit\Spinner\Core\Loop\A\ALoopAdapter;
use AlecRabbit\Spinner\Core\Loop\A\ALoopProbe;
use AlecRabbit\Spinner\Core\Loop\Contract\ILoop;
use AlecRabbit\Tests\TestCase\TestCaseWithPrebuiltMocks;
use AlecRabbit\Tests\Unit\Spinner\Asynchronous\Override\ALoopAdapterOverride;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\MockObject\MockObject;

final class LoopFactoryTest extends TestCaseWithPrebuiltMocks
{
    #[Test]
    public function canBeCreated(): void
    {
        $loopFactory = $this->getTesteeInstance();

        self::assertInstanceOf(LoopFactory::class, $loopFactory);
    }


    public function getTesteeInstance(
        ?ILoopProbeFactory $loopProbeFactory = null,
        ?ILoopSetupBuilder $loopSetupBuilder = null,

    ): ILoopFactory {
        return
            new LoopFactory(
                loopProbeFactory: $loopProbeFactory ?? $this->getLoopProbeFactoryMock(),
                loopSetupBuilder: $loopSetupBuilder ?? $this->getLoopSetupBuilderMock(),
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
        return $loopProbeFactory;
    }

    #[Test]
    public function canGetLoopSetup(): void
    {
        $loopFactory = $this->getTesteeInstance();

        self::assertInstanceOf(LoopFactory::class, $loopFactory);

        $loopSetup = $loopFactory->getLoopSetup($this->getLoopConfigStub());

        self::assertInstanceOf(ALoopAdapter::class, $loopFactory->getLoop());
    }

    protected function getLoopConfigStub(): ILoopConfig
    {
        return $this->createStub(ILoopConfig::class);
    }

    protected function setUp(): void
    {
        self::setValue(LoopFactory::class, 'loop', null);
    }
}
