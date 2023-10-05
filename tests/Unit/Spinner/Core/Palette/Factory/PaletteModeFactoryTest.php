<?php

declare(strict_types=1);

namespace AlecRabbit\Tests\Unit\Spinner\Core\Palette\Factory;

use AlecRabbit\Spinner\Contract\Mode\StylingMethodMode;
use AlecRabbit\Spinner\Core\Config\Contract\IConfig;
use AlecRabbit\Spinner\Core\Config\Contract\IOutputConfig;
use AlecRabbit\Spinner\Core\Contract\IConfigProvider;
use AlecRabbit\Spinner\Core\Palette\Factory\Contract\IPaletteModeFactory;
use AlecRabbit\Spinner\Core\Palette\Factory\PaletteModeFactory;
use AlecRabbit\Tests\TestCase\TestCase;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\MockObject\MockObject;

final class PaletteModeFactoryTest extends TestCase
{
    #[Test]
    public function canBeInstantiated(): void
    {
        $pattern = $this->getTesteeInstance();

        self::assertInstanceOf(PaletteModeFactory::class, $pattern);
    }

    public function getTesteeInstance(
        ?IConfigProvider $configProvider = null,
    ): IPaletteModeFactory {
        return
            new PaletteModeFactory(
                configProvider: $configProvider ?? $this->getConfigProviderMock(),
            );
    }

    private function getConfigProviderMock(): MockObject&IConfigProvider
    {
        return $this->createMock(IConfigProvider::class);
    }

    #[Test]
    public function canCreate(): void
    {
        $stylingMode = StylingMethodMode::ANSI4;

        $outputConfig = $this->getOutputConfigMock();
        $outputConfig
            ->expects(self::once())
            ->method('getStylingMethodMode')
            ->willReturn($stylingMode)
        ;

        $config = $this->getConfigMock();
        $config
            ->expects(self::once())
            ->method('get')
            ->with(self::identicalTo(IOutputConfig::class))
            ->willReturn($outputConfig)
        ;

        $configProvider = $this->getConfigProviderMock();
        $configProvider
            ->expects(self::once())
            ->method('getConfig')
            ->willReturn($config)
        ;

        $paletteModeFactory = $this->getTesteeInstance(
            configProvider: $configProvider,
        );

        $paletteMode = $paletteModeFactory->create();

        self::assertSame($stylingMode, $paletteMode->getStylingMode());
    }

    private function getOutputConfigMock(): MockObject&IOutputConfig
    {
        return $this->createMock(IOutputConfig::class);
    }

    private function getConfigMock(): MockObject&IConfig
    {
        return $this->createMock(IConfig::class);
    }
}
