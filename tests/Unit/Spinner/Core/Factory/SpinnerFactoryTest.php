<?php

declare(strict_types=1);

namespace AlecRabbit\Tests\Spinner\Unit\Spinner\Core\Factory;

use AlecRabbit\Spinner\Container\Contract\IContainer;
use AlecRabbit\Spinner\Core\A\ASpinner;
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
        $spinnerFactory = $this->getTesteeInstance(container: null);

        self::assertInstanceOf(SpinnerFactory::class, $spinnerFactory);
    }

    public function getTesteeInstance(
        (MockObject&IContainer)|null $container,
    ): ISpinnerFactory {
        return
            new SpinnerFactory(
                container: $container ?? $this->getContainerMock(),
            );
    }

    #[Test]
    public function canCreateSpinner(): void
    {
        $container = $this->getContainerMock();

        $spinnerBuilder = $this->getSpinnerBuilderMock();
        $spinnerBuilder
            ->method('build')
            ->willReturn($this->getSpinnerMock())
        ;

        $container
            ->method('get')
            ->willReturn(
                $spinnerBuilder,
                $this->getConfigBuilderMock(),
                $this->getDriverBuilderMock(),
                $this->getWidgetBuilderMock(),
            )
        ;

        $spinnerFactory = $this->getTesteeInstance(container: $container);

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

        $spinnerFactory = $this->getTesteeInstance(container: $container);

        $config = $this->getConfigMock();

        $spinner = $spinnerFactory->createSpinner($config);

        self::assertInstanceOf(ASpinner::class, $spinner);
    }
}
