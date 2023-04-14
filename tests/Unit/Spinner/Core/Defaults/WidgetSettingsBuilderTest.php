<?php

declare(strict_types=1);

namespace AlecRabbit\Tests\Unit\Spinner\Core\Defaults;

use AlecRabbit\Spinner\Core\Defaults\Contract\IWidgetSettingsBuilder;
use AlecRabbit\Spinner\Core\Defaults\WidgetSettings;
use AlecRabbit\Spinner\Core\Defaults\WidgetSettingsBuilder;
use AlecRabbit\Spinner\Exception\LogicException;
use AlecRabbit\Tests\TestCase\TestCaseWithPrebuiltMocksAndStubs;
use PHPUnit\Framework\Attributes\Test;

final class WidgetSettingsBuilderTest extends TestCaseWithPrebuiltMocksAndStubs
{
    #[Test]
    public function canBeCreated(): void
    {
        $builder = $this->getTesteeInstance();

        self::assertInstanceOf(WidgetSettingsBuilder::class, $builder);
    }

    public function getTesteeInstance(): IWidgetSettingsBuilder
    {
        return
            new WidgetSettingsBuilder();
    }

    #[Test]
    public function canBuild(): void
    {
        $widgetSettingsBuilder = $this->getTesteeInstance();

        $widgetSettings =
            $widgetSettingsBuilder
                ->withLeadingSpacer($this->getFrameMock())
                ->withTrailingSpacer($this->getFrameMock())
                ->withStylePattern($this->getPatternMock())
                ->withCharPattern($this->getPatternMock())
                ->build()
        ;

        self::assertInstanceOf(WidgetSettingsBuilder::class, $widgetSettingsBuilder);
        self::assertInstanceOf(WidgetSettings::class, $widgetSettings);
    }

    #[Test]
    public function throwsIfLeadingSpacerIsNotSet(): void
    {
        $exceptionClass = LogicException::class;
        $exceptionMessage = 'Leading spacer is not set.';

        $test = function () {
            $widgetSettingsBuilder = $this->getTesteeInstance();

            $widgetSettings =
                $widgetSettingsBuilder
                    ->withTrailingSpacer($this->getFrameMock())
                    ->withStylePattern($this->getPatternMock())
                    ->withCharPattern($this->getPatternMock())
                    ->build()
            ;

            self::assertInstanceOf(WidgetSettings::class, $widgetSettings);
        };

        $this->wrapExceptionTest(
            exceptionClass: $exceptionClass,
            exceptionMessage: $exceptionMessage,
            test: $test,
        );
    }

    #[Test]
    public function throwsIfTrailingSpacerIsNotSet(): void
    {
        $exceptionClass = LogicException::class;
        $exceptionMessage = 'Trailing spacer is not set.';

        $test = function () {
            $widgetSettingsBuilder = $this->getTesteeInstance();

            $widgetSettings =
                $widgetSettingsBuilder
                    ->withLeadingSpacer($this->getFrameMock())
                    ->withStylePattern($this->getPatternMock())
                    ->withCharPattern($this->getPatternMock())
                    ->build()
            ;

            self::assertInstanceOf(WidgetSettings::class, $widgetSettings);
        };

        $this->wrapExceptionTest(
            exceptionClass: $exceptionClass,
            exceptionMessage: $exceptionMessage,
            test: $test,
        );
    }

    #[Test]
    public function throwsIfStylePatternIsNotSet(): void
    {
        $exceptionClass = LogicException::class;
        $exceptionMessage = 'Style pattern is not set.';

        $test = function () {
            $widgetSettingsBuilder = $this->getTesteeInstance();

            $widgetSettings =
                $widgetSettingsBuilder
                    ->withLeadingSpacer($this->getFrameMock())
                    ->withTrailingSpacer($this->getFrameMock())
                    ->withCharPattern($this->getPatternMock())
                    ->build()
            ;

            self::assertInstanceOf(WidgetSettings::class, $widgetSettings);
        };

        $this->wrapExceptionTest(
            exceptionClass: $exceptionClass,
            exceptionMessage: $exceptionMessage,
            test: $test,
        );
    }

    #[Test]
    public function throwsIfCharPatternIsNotSet(): void
    {
        $exceptionClass = LogicException::class;
        $exceptionMessage = 'Char pattern is not set.';

        $test = function () {
            $widgetSettingsBuilder = $this->getTesteeInstance();

            $widgetSettings =
                $widgetSettingsBuilder
                    ->withLeadingSpacer($this->getFrameMock())
                    ->withTrailingSpacer($this->getFrameMock())
                    ->withStylePattern($this->getPatternMock())
                    ->build()
            ;

            self::assertInstanceOf(WidgetSettings::class, $widgetSettings);
        };

        $this->wrapExceptionTest(
            exceptionClass: $exceptionClass,
            exceptionMessage: $exceptionMessage,
            test: $test,
        );
    }
}
