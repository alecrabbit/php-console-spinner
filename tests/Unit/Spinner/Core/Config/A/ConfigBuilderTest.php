<?php

declare(strict_types=1);

namespace AlecRabbit\Tests\Spinner\Unit\Spinner\Core\Config\A;

use AlecRabbit\Spinner\Container\Contract\IContainer;
use AlecRabbit\Spinner\Core\A\ASpinner;
use AlecRabbit\Spinner\Core\Config\A\AConfigBuilder;
use AlecRabbit\Spinner\Core\Config\ConfigBuilder;
use AlecRabbit\Spinner\Core\Config\Contract\IConfig;
use AlecRabbit\Spinner\Core\Config\Contract\IConfigBuilder;
use AlecRabbit\Spinner\Core\Contract\IDriverBuilder;
use AlecRabbit\Spinner\Core\Contract\ISpinnerBuilder;
use AlecRabbit\Spinner\Core\SpinnerBuilder;
use AlecRabbit\Spinner\Core\Widget\Contract\IWidgetBuilder;
use AlecRabbit\Tests\Spinner\TestCase\TestCase;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\MockObject\MockObject;

final class ConfigBuilderTest extends TestCase
{
    #[Test]
    public function canBeCreated(): void
    {
        $configBuilder = $this->getTesteeInstance(container: null);

        self::assertInstanceOf(ConfigBuilder::class, $configBuilder);
    }

    public function getTesteeInstance(
        (MockObject&IContainer)|null $container,
    ): IConfigBuilder {
        return
            new ConfigBuilder(
                container: $container ?? $this->getContainerMock(),
            );
    }

    protected function getContainerMock(): MockObject&IContainer
    {

        return $this->createMock(IContainer::class);
    }

    #[Test]
    public function canBuildDefaultConfig(): void
    {
        $configBuilder = $this->getTesteeInstance(container: null);

        self::assertInstanceOf(ConfigBuilder::class, $configBuilder);

        $config = $configBuilder->build();
    }

}
