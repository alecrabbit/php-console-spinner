<?php

declare(strict_types=1);

namespace AlecRabbit\Tests\Unit\Spinner\Asynchronous\Factory;

use AlecRabbit\Spinner\Core\Contract\IDefaultsProvider;
use AlecRabbit\Spinner\Core\Contract\IDriver;
use AlecRabbit\Spinner\Core\Contract\ILoopSetupBuilder;
use AlecRabbit\Spinner\Core\Factory\Contract\ILoopFactory;
use AlecRabbit\Spinner\Core\Factory\Contract\ILoopProbeFactory;
use AlecRabbit\Spinner\Core\Factory\LoopFactory;
use AlecRabbit\Spinner\Core\Loop\A\ALoopAdapter;
use AlecRabbit\Spinner\Core\Loop\A\ALoopProbe;
use AlecRabbit\Spinner\Core\Loop\Contract\ILoop;
use AlecRabbit\Tests\TestCase\TestCaseWithPrebuiltMocksAndStubs;
use AlecRabbit\Tests\Unit\Spinner\Asynchronous\Override\ALoopAdapterOverride;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\MockObject\MockObject;

final class LoopFactoryTest extends TestCaseWithPrebuiltMocksAndStubs
{
    #[Test]
    public function canBeCreated(): void
    {
        $loopFactory = $this->getTesteeInstance();

        self::assertInstanceOf(LoopFactory::class, $loopFactory);
    }


    public function getTesteeInstance(
        ?IDefaultsProvider $defaultsProvider = null,
        ?ILoopProbeFactory $loopProbeFactory = null,
        ?ILoopSetupBuilder $loopSetupBuilder = null,
    ): ILoopFactory {
        return
            new LoopFactory(
                defaultsProvider: $defaultsProvider ?? $this->getDefaultsProviderMock(),
                loopProbeFactory: $loopProbeFactory ?? $this->getLoopProbeFactoryMock(),
                loopSetupBuilder: $loopSetupBuilder ?? $this->getLoopSetupBuilderMock(),
            );
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
    public function canGetLoopAdapter(): void
    {
        $loopFactory = $this->getTesteeInstance();

        self::assertInstanceOf(ALoopAdapter::class, $loopFactory->getLoop());
    }

    #[Test]
    public function canGetLoopSetup(): void
    {
        $loopSetupStub = $this->getLoopSetupStub();
        $loopSetupBuilder = $this->getLoopSetupBuilderMock();
        $loopSetupBuilder
            ->expects(self::once())
            ->method('withSettings')
            ->willReturnSelf()
        ;$loopSetupBuilder
            ->expects(self::once())
            ->method('withLoop')
            ->willReturnSelf()
        ;
        $loopSetupBuilder
            ->expects(self::once())
            ->method('build')
            ->willReturn($loopSetupStub)
        ;

        $loopFactory = $this->getTesteeInstance(loopSetupBuilder: $loopSetupBuilder);

        self::assertInstanceOf(LoopFactory::class, $loopFactory);

        $loopSetup = $loopFactory->getLoopSetup();

        self::assertInstanceOf(ALoopAdapter::class, $loopFactory->getLoop());
        self::assertSame($loopSetupStub, $loopSetup);
    }

    protected function setUp(): void
    {
        self::setPropertyValue(LoopFactory::class, 'loop', null);
    }
}
