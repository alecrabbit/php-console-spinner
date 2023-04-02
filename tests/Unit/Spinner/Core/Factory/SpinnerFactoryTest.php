<?php

declare(strict_types=1);

namespace AlecRabbit\Tests\Spinner\Unit\Spinner\Core\Factory;

use AlecRabbit\Spinner\Core\A\ASpinner;
use AlecRabbit\Spinner\Core\Contract\ISpinnerBuilder;
use AlecRabbit\Spinner\Core\Factory\Contract\ISpinnerFactory;
use AlecRabbit\Spinner\Core\Factory\SpinnerFactory;
use AlecRabbit\Tests\Spinner\TestCase\TestCaseWithPrebuiltMocks;
use PHPUnit\Framework\Attributes\Test;

final class SpinnerFactoryTest extends TestCaseWithPrebuiltMocks
{
    #[Test]
    public function canBeCreated(): void
    {
        $spinnerFactory = $this->getTesteeInstance();

        self::assertInstanceOf(SpinnerFactory::class, $spinnerFactory);
    }

    public function getTesteeInstance(?ISpinnerBuilder $spinnerBuilder = null): ISpinnerFactory
    {
        return
            new SpinnerFactory(
                spinnerBuilder: $spinnerBuilder ?? $this->getSpinnerBuilderMock(),
            );
    }

    #[Test]
    public function canCreateSpinner(): void
    {
        $container = $this->getContainerMock();

        $spinnerBuilder = $this->getSpinnerBuilderMock();
        $spinnerBuilder
            ->method('build')
            ->willReturn($this->getSpinnerMock());

        $container
            ->method('get')
            ->willReturn(
                $spinnerBuilder,
                $this->getConfigBuilderMock(),
                $this->getDriverBuilderMock(),
                $this->getWidgetBuilderMock(),
            );

        $spinnerFactory = $this->getTesteeInstance($spinnerBuilder);

        $spinner = $spinnerFactory->createSpinner();

        self::assertInstanceOf(ASpinner::class, $spinner);
    }

    #[Test]
    public function canCreateSpinnerWithConfig(): void
    {
        $container = $this->getContainerMock();

        $spinnerBuilder = $this->getSpinnerBuilderMock();

        $spinnerBuilder
            ->method('withConfig')
            ->willReturn($spinnerBuilder);
        $spinnerBuilder
            ->method('build')
            ->willReturn($this->getSpinnerMock());

        $container
            ->method('get')
            ->willReturn(
                $spinnerBuilder,
                $this->getDriverBuilderMock(),
                $this->getWidgetBuilderMock(),
                $this->getConfigBuilderMock(),
            );

        $spinnerFactory = $this->getTesteeInstance($spinnerBuilder);

        $config = $this->getConfigMock();

        $spinner = $spinnerFactory->createSpinner($config);

        self::assertInstanceOf(ASpinner::class, $spinner);
    }
}
