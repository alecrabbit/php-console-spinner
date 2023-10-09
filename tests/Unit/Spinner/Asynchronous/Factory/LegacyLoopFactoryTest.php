<?php

declare(strict_types=1);

namespace AlecRabbit\Tests\Unit\Spinner\Asynchronous\Factory;

use AlecRabbit\Spinner\Core\Contract\Loop\A\ALoopAdapter;
use AlecRabbit\Spinner\Core\Contract\Loop\A\ALoopProbe;
use AlecRabbit\Spinner\Core\Contract\Loop\ILoop;
use AlecRabbit\Spinner\Core\Factory\Contract\ILegacyLoopAutoStarterFactory;
use AlecRabbit\Spinner\Core\Factory\Contract\ILegacyLoopProbeFactory;
use AlecRabbit\Spinner\Core\Factory\Contract\ILoopFactory;
use AlecRabbit\Spinner\Core\Factory\LegacyLoopFactory;
use AlecRabbit\Tests\TestCase\TestCaseWithPrebuiltMocksAndStubs;
use AlecRabbit\Tests\Unit\Spinner\Asynchronous\Override\ALoopAdapterOverride;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\MockObject\MockObject;
use RuntimeException;

final class LegacyLoopFactoryTest extends TestCaseWithPrebuiltMocksAndStubs
{

    #[Test]
    public function canBeInstantiated(): void
    {
        $loopFactory = $this->getTesteeInstance();

        self::assertInstanceOf(LegacyLoopFactory::class, $loopFactory);
    }

    public function getTesteeInstance(
        ?ILegacyLoopProbeFactory $loopProbeFactory = null,
        ?ILegacyLoopAutoStarterFactory $loopAutoStarterFactory = null,
    ): ILoopFactory {
        return new LegacyLoopFactory(
            loopProbeFactory: $loopProbeFactory ?? $this->getLoopProbeFactoryMock(),
            loopAutoStarterFactory: $loopAutoStarterFactory ?? $this->getLoopAutoStarterFactoryMock(),
        );
    }

    protected function getLoopProbeFactoryMock(): MockObject&ILegacyLoopProbeFactory
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

                    public static function getCreatorClass(): string
                    {
                        throw new RuntimeException('INTENTIONALLY Not implemented.');
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

        self::assertInstanceOf(ALoopAdapter::class, $loopFactory->create());
    }

    protected function setUp(): void
    {
        self::setPropertyValue(LegacyLoopFactory::class, 'loop', null);
    }
}
