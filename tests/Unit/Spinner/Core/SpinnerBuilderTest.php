<?php

declare(strict_types=1);

namespace AlecRabbit\Tests\Spinner\Unit\Spinner\Core;

use AlecRabbit\Spinner\Core\A\ASpinner;
use AlecRabbit\Spinner\Core\Config\Contract\IConfig;
use AlecRabbit\Spinner\Core\Config\Contract\IDriverBuilder;
use AlecRabbit\Spinner\Core\Contract\IConfigBuilder;
use AlecRabbit\Spinner\Core\Contract\ISpinnerBuilder;
use AlecRabbit\Spinner\Core\SpinnerBuilder;
use AlecRabbit\Spinner\Core\Widget\Contract\IWidgetBuilder;
use AlecRabbit\Spinner\Exception\LogicException;
use AlecRabbit\Tests\Spinner\TestCase\TestCaseWithPrebuiltMocks;
use PHPUnit\Framework\Attributes\Test;

final class SpinnerBuilderTest extends TestCaseWithPrebuiltMocks
{
    #[Test]
    public function canBeCreated(): void
    {
        $spinnerBuilder = $this->getTesteeInstance();

        self::assertInstanceOf(SpinnerBuilder::class, $spinnerBuilder);
    }

    public function getTesteeInstance(
        ?IDriverBuilder $driverBuilder = null,
        ?IWidgetBuilder $widgetBuilder = null,
    ): ISpinnerBuilder {
        return
            new SpinnerBuilder(
                driverBuilder: $driverBuilder ?? $this->getDriverBuilderMock(),
                widgetBuilder: $widgetBuilder ?? $this->getWidgetBuilderMock(),
            );
    }

    #[Test]
    public function canAcceptConfig(): void
    {
        $spinnerBuilder = $this->getTesteeInstance();

        $config = $this->createMock(IConfig::class);

        $spinnerBuilder = $spinnerBuilder->withConfig($config);
        self::assertInstanceOf(SpinnerBuilder::class, $spinnerBuilder);
        self::assertInstanceOf(IConfig::class, self::getValue('config', $spinnerBuilder));
    }

    #[Test]
    public function throwsWithNoConfigProvided(): void
    {
        $exceptionClass = LogicException::class;
        $exceptionMessage = 'Config is not set.';

        $this->expectException($exceptionClass);
        $this->expectExceptionMessage($exceptionMessage);

        $spinnerBuilder = $this->getTesteeInstance();

        $spinner = $spinnerBuilder->build();

        self::failTest(self::exceptionNotThrownString($exceptionClass, $exceptionMessage));
    }
}
