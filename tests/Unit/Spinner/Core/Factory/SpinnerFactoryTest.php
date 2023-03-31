<?php

declare(strict_types=1);

namespace AlecRabbit\Tests\Spinner\Unit\Spinner\Core\Factory;

use AlecRabbit\Spinner\Container\Contract\IContainer;
use AlecRabbit\Spinner\Core\A\ASpinner;
use AlecRabbit\Spinner\Core\Config\Contract\IConfig;
use AlecRabbit\Spinner\Core\Config\Contract\IConfigBuilder;
use AlecRabbit\Spinner\Core\Config\Contract\IDriverBuilder;
use AlecRabbit\Spinner\Core\Factory\Contract\ISpinnerFactory;
use AlecRabbit\Spinner\Core\Factory\SpinnerFactory;
use AlecRabbit\Spinner\Core\Widget\Contract\IWidgetBuilder;
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
        $container = $this->createMock(IContainer::class);
        $container
            ->method('get')
            ->willReturn(
                $this->createMock(IConfigBuilder::class),
                $this->createMock(IDriverBuilder::class),
                $this->createMock(IWidgetBuilder::class),
            )
        ;

        $spinnerFactory = $this->getTesteeInstance(container: $container);

        $spinner = $spinnerFactory->createSpinner();

        self::assertInstanceOf(ASpinner::class, $spinner);
    }

    #[Test]
    public function canCreateSpinnerWithConfig(): void
    {
        $container = $this->createMock(IContainer::class);
        $container
            ->method('get')
            ->willReturn(
                $this->createMock(IDriverBuilder::class),
                $this->createMock(IWidgetBuilder::class),
                $this->createMock(IConfigBuilder::class),
            )
        ;

        $spinnerFactory = $this->getTesteeInstance(container: $container);

        $config = $this->createMock(IConfig::class);

        $spinner = $spinnerFactory->createSpinner($config);

        self::assertInstanceOf(ASpinner::class, $spinner);
    }
}
