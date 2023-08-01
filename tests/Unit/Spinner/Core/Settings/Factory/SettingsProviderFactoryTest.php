<?php

declare(strict_types=1);

namespace AlecRabbit\Tests\Unit\Spinner\Core\Settings\Factory;

use AlecRabbit\Spinner\Core\Settings\Contract\Builder\ISettingsProviderBuilder;
use AlecRabbit\Spinner\Core\Settings\Contract\Factory\ISettingsProviderFactory;
use AlecRabbit\Spinner\Core\Settings\Contract\ISettings;
use AlecRabbit\Spinner\Core\Settings\Contract\ISettingsProvider;
use AlecRabbit\Spinner\Core\Settings\Factory\SettingsProviderFactory;
use AlecRabbit\Spinner\Core\Settings\SettingsProvider;
use AlecRabbit\Tests\TestCase\TestCaseWithPrebuiltMocksAndStubs;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\MockObject\MockObject;

final class SettingsProviderFactoryTest extends TestCaseWithPrebuiltMocksAndStubs
{
    #[Test]
    public function canBeInstantiated(): void
    {
        $factory = $this->getTesteeInstance();

        self::assertInstanceOf(SettingsProviderFactory::class, $factory);
    }

    public function getTesteeInstance(
        ?ISettingsProviderBuilder $builder = null,
    ): ISettingsProviderFactory {
        return
            new SettingsProviderFactory(
                builder: $builder ?? $this->getSettingsProviderBuilderMock(),
            );
    }

    protected function getSettingsProviderBuilderMock(): MockObject&ISettingsProviderBuilder
    {
        return $this->createMock(ISettingsProviderBuilder::class);
    }

    #[Test]
    public function canCreate(): void
    {
        $provider = $this->getSettingsProviderMock();
        $builder = $this->getSettingsProviderBuilderMock();
        $builder
            ->expects($this->once())
            ->method('withUserSettings')
            ->with(self::isInstanceOf(ISettings::class))
            ->willReturnSelf();
        $builder
            ->expects($this->once())
            ->method('withDetectedSettings')
            ->with(self::isInstanceOf(ISettings::class))
            ->willReturnSelf();
        $builder
            ->expects($this->once())
            ->method('withDefaultSettings')
            ->with(self::isInstanceOf(ISettings::class))
            ->willReturnSelf();
        $builder
            ->expects($this->once())
            ->method('build')
            ->willReturn($provider)
        ;

        $factory = $this->getTesteeInstance(
            builder: $builder,
        );

        self::assertSame($provider, $factory->create());
    }

    protected function getSettingsProviderMock(): MockObject&ISettingsProvider
    {
        return $this->createMock(ISettingsProvider::class);
    }

}
