<?php

declare(strict_types=1);

namespace AlecRabbit\Tests\Spinner\Unit\Spinner\Core;

use AlecRabbit\Spinner\Container\Contract\IContainer;
use AlecRabbit\Spinner\Core\A\ASpinner;
use AlecRabbit\Spinner\Core\Config\Contract\IConfig;
use AlecRabbit\Spinner\Core\Config\Contract\IConfigBuilder;
use AlecRabbit\Spinner\Core\Contract\IDriverBuilder;
use AlecRabbit\Spinner\Core\Contract\ISpinnerBuilder;
use AlecRabbit\Spinner\Core\SpinnerBuilder;
use AlecRabbit\Spinner\Core\Widget\Contract\IWidgetBuilder;
use AlecRabbit\Tests\Spinner\TestCase\TestCase;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\MockObject\MockObject;

final class SpinnerBuilderTest extends TestCase
{
    #[Test]
    public function canBeCreated(): void
    {
        $spinnerBuilder = $this->getTesteeInstance(container: null);

        self::assertInstanceOf(SpinnerBuilder::class, $spinnerBuilder);
    }

    public function getTesteeInstance(
        (MockObject&IContainer)|null $container,
    ): ISpinnerBuilder {
        return
            new SpinnerBuilder(
                container: $container ?? $this->getContainerMock(),
            );
    }

    protected function getContainerMock(): MockObject&IContainer
    {

        return $this->createMock(IContainer::class);
    }

    #[Test]
    public function canAcceptConfig(): void
    {
        $spinnerBuilder = $this->getTesteeInstance(container: null);

        $config = $this->createMock(IConfig::class);

        $spinnerBuilder = $spinnerBuilder->withConfig($config);
        self::assertInstanceOf(SpinnerBuilder::class, $spinnerBuilder);
        self::assertInstanceOf(IConfig::class, self::getValue('config', $spinnerBuilder));
    }

    #[Test]
    public function canBuildSpinnerWithNoConfigProvided(): void
    {
        $container = $this->createMock(IContainer::class);
        $container
            ->method('get')
            ->willReturn(
                $this->createMock(IConfigBuilder::class),
                $this->createMock(IDriverBuilder::class),
                $this->createMock(IWidgetBuilder::class),
            );

        $spinnerBuilder = $this->getTesteeInstance(container: $container);

        $spinner = $spinnerBuilder->build();

        self::assertInstanceOf(SpinnerBuilder::class, $spinnerBuilder);
        self::assertInstanceOf(ASpinner::class, $spinner);
        self::assertInstanceOf(IConfig::class, self::getValue('config', $spinnerBuilder));
    }
}
