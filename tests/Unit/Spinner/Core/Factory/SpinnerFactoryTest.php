<?php

declare(strict_types=1);

namespace AlecRabbit\Tests\Spinner\Unit\Spinner\Core\Factory;

use AlecRabbit\Spinner\Contract\OptionAutoStart;
use AlecRabbit\Spinner\Contract\OptionRunMode;
use AlecRabbit\Spinner\Contract\OptionSignalHandlers;
use AlecRabbit\Spinner\Core\A\ASpinner;
use AlecRabbit\Spinner\Core\Config\Contract\IConfig;
use AlecRabbit\Spinner\Core\Config\LoopConfig;
use AlecRabbit\Spinner\Core\Contract\IConfigBuilder;
use AlecRabbit\Spinner\Core\Contract\ILoopInitializer;
use AlecRabbit\Spinner\Core\Contract\ISpinnerBuilder;
use AlecRabbit\Spinner\Core\Contract\ISpinnerInitializer;
use AlecRabbit\Spinner\Core\Factory\Contract\ISpinnerFactory;
use AlecRabbit\Spinner\Core\Factory\SpinnerFactory;
use AlecRabbit\Tests\Spinner\TestCase\TestCaseWithPrebuiltMocks;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\MockObject\MockObject;

final class SpinnerFactoryTest extends TestCaseWithPrebuiltMocks
{
    #[Test]
    public function canBeCreated(): void
    {
        $spinnerFactory = $this->getTesteeInstance();

        self::assertInstanceOf(SpinnerFactory::class, $spinnerFactory);
    }

    public function getTesteeInstance(
        ?ISpinnerBuilder $spinnerBuilder = null,
        ?ISpinnerInitializer $spinnerInitializer = null,
        ?ILoopInitializer $loopInitializer = null,
        ?IConfigBuilder $configBuilder = null,
    ): ISpinnerFactory {
        return
            new SpinnerFactory(
                spinnerBuilder: $spinnerBuilder ?? $this->getSpinnerBuilderMock(),
                spinnerInitializer: $spinnerInitializer ??  $this->getSpinnerInitializerMock(),
                loopInitializer: $loopInitializer ??  $this->getLoopInitializerMock(),
                configBuilder: $configBuilder ??  $this->getConfigBuilderMock(),
            );
    }

    #[Test]
    public function canCreateSpinner(): void
    {
        $container = $this->getContainerMock();

        $config = $this->getConfigMock();

        $spinnerBuilder = $this->getSpinnerBuilderMock();
        $spinnerBuilder
            ->method('withConfig')
            ->willReturn($spinnerBuilder)
        ;
        $spinnerBuilder
            ->method('build')
            ->willReturn($this->getSpinnerMock())
        ;

        $configBuilder = $this->getConfigBuilderMock();
        $configBuilder
            ->method('build')
            ->willReturn($config);

        $container
            ->method('get')
            ->willReturn(
                $spinnerBuilder,
                $configBuilder,
                $this->getDriverBuilderMock(),
                $this->getWidgetBuilderMock(),
            )
        ;

        $spinnerFactory = $this->getTesteeInstance($spinnerBuilder);

        $spinner = $spinnerFactory->createSpinner($config);

        self::assertInstanceOf(ASpinner::class, $spinner);
    }

    #[Test]
    public function canCreateSpinnerWithConfig(): void
    {
        $container = $this->getContainerMock();

        $spinnerBuilder = $this->getSpinnerBuilderMock();

        $spinnerBuilder
            ->method('withConfig')
            ->willReturn($spinnerBuilder)
        ;
        $spinnerBuilder
            ->method('build')
            ->willReturn($this->getSpinnerMock())
        ;

        $container
            ->method('get')
            ->willReturn(
                $spinnerBuilder,
                $this->getDriverBuilderMock(),
                $this->getWidgetBuilderMock(),
                $this->getConfigBuilderMock(),
            )
        ;

        $spinnerFactory = $this->getTesteeInstance($spinnerBuilder);

        $config = $this->getConfigMock();

        $spinner = $spinnerFactory->createSpinner($config);

        self::assertInstanceOf(ASpinner::class, $spinner);
    }

    protected function getConfigMock(): MockObject&IConfig
    {
        $config = parent::getConfigMock();

        $loopConfig =
            new LoopConfig(
                OptionRunMode::SYNCHRONOUS,
                OptionAutoStart::DISABLED,
                OptionSignalHandlers::DISABLED
            );

        $config
            ->method('getLoopConfig')
            ->willReturn($loopConfig);

        return $config;
    }


}
