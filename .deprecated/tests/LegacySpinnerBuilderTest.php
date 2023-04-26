<?php

declare(strict_types=1);

namespace AlecRabbit\Tests\Unit\Spinner\Core;

use AlecRabbit\Spinner\Core\Config\Contract\IConfig;
use AlecRabbit\Spinner\Core\Contract\ILegacyDriverBuilder;
use AlecRabbit\Spinner\Core\Contract\ILegacySpinnerBuilder;
use AlecRabbit\Spinner\Core\LegacySpinnerBuilder;
use AlecRabbit\Spinner\Core\Widget\Contract\IWidgetBuilder;
use AlecRabbit\Spinner\Exception\LogicException;
use AlecRabbit\Tests\TestCase\TestCaseWithPrebuiltMocksAndStubs;
use PHPUnit\Framework\Attributes\Test;

final class LegacySpinnerBuilderTest extends TestCaseWithPrebuiltMocksAndStubs
{
    #[Test]
    public function canBeCreated(): void
    {
        $spinnerBuilder = $this->getTesteeInstance();

        self::assertInstanceOf(LegacySpinnerBuilder::class, $spinnerBuilder);
    }

    public function getTesteeInstance(
        ?ILegacyDriverBuilder $driverBuilder = null,
        ?IWidgetBuilder $widgetBuilder = null,
    ): ILegacySpinnerBuilder {
        return
            new LegacySpinnerBuilder(
                driverBuilder: $driverBuilder ?? $this->getLegacyDriverBuilderMock(),
                widgetBuilder: $widgetBuilder ?? $this->getWidgetBuilderMock(),
            );
    }

    #[Test]
    public function canAcceptConfig(): void
    {
        $spinnerBuilder = $this->getTesteeInstance();

        $config = $this->createMock(IConfig::class);

        $spinnerBuilder = $spinnerBuilder->withConfig($config);
        self::assertInstanceOf(LegacySpinnerBuilder::class, $spinnerBuilder);
        self::assertInstanceOf(IConfig::class, self::getPropertyValue('config', $spinnerBuilder));
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
