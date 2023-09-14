<?php

declare(strict_types=1);

namespace AlecRabbit\Tests\Unit\Spinner\Core\Settings\Factory;

use AlecRabbit\Spinner\Core\Settings\Contract\Builder\ISettingsProviderBuilder;
use AlecRabbit\Spinner\Core\Settings\Contract\Factory\IDefaultSettingsFactory;
use AlecRabbit\Spinner\Core\Settings\Contract\Factory\IDetectedSettingsFactory;
use AlecRabbit\Spinner\Core\Settings\Contract\Factory\ISettingsProviderFactory;
use AlecRabbit\Spinner\Core\Settings\Contract\Factory\IUserSettingsFactory;
use AlecRabbit\Spinner\Core\Settings\Contract\ISettings;
use AlecRabbit\Spinner\Core\Settings\Contract\ISettingsProvider;
use AlecRabbit\Spinner\Core\Settings\Factory\SettingsProviderFactory;
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
        ?IUserSettingsFactory $userSettingsFactory = null,
    ): ISettingsProviderFactory {
        return
            new SettingsProviderFactory(
                builder: $builder ?? $this->getSettingsProviderBuilderMock(),
                userSettingsFactory: $userSettingsFactory ?? $this->getUserSettingsFactoryMock(),
            );
    }

    protected function getSettingsProviderBuilderMock(): MockObject&ISettingsProviderBuilder
    {
        return $this->createMock(ISettingsProviderBuilder::class);
    }

    protected function getUserSettingsFactoryMock(): MockObject&IUserSettingsFactory
    {
        return $this->createMock(IUserSettingsFactory::class);
    }

    #[Test]
    public function canCreate(): void
    {
        $provider = $this->getSettingsProviderMock();

        $userSettings = $this->getSettingsMock();
        $userSettingsFactory = $this->getUserSettingsFactoryMock();
        $userSettingsFactory
            ->expects(self::once())
            ->method('create')
            ->willReturn($userSettings)
        ;

        $builder = $this->getSettingsProviderBuilderMock();
        $builder
            ->expects(self::once())
            ->method('withSettings')
            ->with($userSettings)
            ->willReturnSelf()
        ;
        $builder
            ->expects(self::once())
            ->method('build')
            ->willReturn($provider)
        ;

        $factory = $this->getTesteeInstance(
            builder: $builder,
            userSettingsFactory: $userSettingsFactory,
        );

        self::assertSame($provider, $factory->create());
    }

    protected function getSettingsProviderMock(): MockObject&ISettingsProvider
    {
        return $this->createMock(ISettingsProvider::class);
    }

    protected function getSettingsMock(): MockObject&ISettings
    {
        return $this->createMock(ISettings::class);
    }

    protected function getDefaultSettingsFactoryMock(): MockObject&IDefaultSettingsFactory
    {
        return $this->createMock(IDefaultSettingsFactory::class);
    }

    protected function getDetectedSettingsFactoryMock(): MockObject&IDetectedSettingsFactory
    {
        return $this->createMock(IDetectedSettingsFactory::class);
    }

}
