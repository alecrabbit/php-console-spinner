<?php

declare(strict_types=1);

namespace AlecRabbit\Tests\Unit\Spinner\Core\Settings\Builder;

use AlecRabbit\Spinner\Core\Settings\Builder\SettingsProviderBuilder;
use AlecRabbit\Spinner\Core\Settings\Contract\Builder\ISettingsProviderBuilder;
use AlecRabbit\Spinner\Core\Settings\Contract\ISettings;
use AlecRabbit\Spinner\Core\Settings\SettingsProvider;
use AlecRabbit\Spinner\Exception\LogicException;
use AlecRabbit\Tests\TestCase\TestCase;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\MockObject\MockObject;

final class SettingsProviderBuilderTest extends TestCase
{
    #[Test]
    public function canBeInstantiated(): void
    {
        $builder = $this->getTesteeInstance();

        self::assertInstanceOf(SettingsProviderBuilder::class, $builder);
    }

    public function getTesteeInstance(): ISettingsProviderBuilder
    {
        return
            new SettingsProviderBuilder();
    }

    #[Test]
    public function withUserSettingsReturnsOtherInstanceOfBuilder(): void
    {
        $providerBuilder = $this->getTesteeInstance();

        $builder =
            $providerBuilder
                ->withSettings($this->getSettingsMock())
        ;

        self::assertNotSame($builder, $providerBuilder);
    }

    protected function getSettingsMock(): MockObject&ISettings
    {
        return $this->createMock(ISettings::class);
    }

    #[Test]
    public function canBuild(): void
    {
        $builder = $this->getTesteeInstance();

        $settings =
            $builder
                ->withSettings($this->getSettingsMock())
                ->withDefaultSettings($this->getSettingsMock())
                ->withDetectedSettings($this->getSettingsMock())
                ->build()
        ;

        self::assertInstanceOf(SettingsProvider::class, $settings);
    }

    #[Test]
    public function throwsIfUserSettingsAreNotSet(): void
    {
        $exceptionClass = LogicException::class;
        $exceptionMessage = 'User settings are not set.';

        $test = function (): void {
            $builder = $this->getTesteeInstance();

            $builder
                ->build()
            ;
        };

        $this->wrapExceptionTest(
            test: $test,
            exception: $exceptionClass,
            message: $exceptionMessage,
        );
    }

    #[Test]
    public function throwsIfDefaultSettingsAreNotSet(): void
    {
        $exceptionClass = LogicException::class;
        $exceptionMessage = 'Default settings are not set.';

        $test = function (): void {
            $builder = $this->getTesteeInstance();

            $builder
                ->withSettings($this->getSettingsMock())
                ->withDetectedSettings($this->getSettingsMock())
                ->build()
            ;
        };

        $this->wrapExceptionTest(
            test: $test,
            exception: $exceptionClass,
            message: $exceptionMessage,
        );
    }

    #[Test]
    public function throwsIfDetectedSettingsAreNotSet(): void
    {
        $exceptionClass = LogicException::class;
        $exceptionMessage = 'Detected settings are not set.';

        $test = function (): void {
            $builder = $this->getTesteeInstance();

            $builder
                ->withSettings($this->getSettingsMock())
                ->withDefaultSettings($this->getSettingsMock())
                ->build()
            ;
        };

        $this->wrapExceptionTest(
            test: $test,
            exception: $exceptionClass,
            message: $exceptionMessage,
        );
    }
}
