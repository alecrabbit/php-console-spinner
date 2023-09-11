<?php

declare(strict_types=1);

namespace AlecRabbit\Tests\Unit\Spinner\Core\Defaults;

use AlecRabbit\Spinner\Core\Builder\Settings\Legacy\Contract\ILegacyWidgetSettingsBuilder;
use AlecRabbit\Spinner\Core\Builder\Settings\Legacy\LegacyWidgetSettingsBuilder;
use AlecRabbit\Spinner\Core\Settings\Legacy\LegacyWidgetSettings;
use AlecRabbit\Spinner\Exception\LogicException;
use AlecRabbit\Tests\TestCase\TestCaseWithPrebuiltMocksAndStubs;
use PHPUnit\Framework\Attributes\Test;

final class WidgetSettingsBuilderTest extends TestCaseWithPrebuiltMocksAndStubs
{
    #[Test]
    public function canBeInstantiated(): void
    {
        $builder = $this->getTesteeInstance();

        self::assertInstanceOf(LegacyWidgetSettingsBuilder::class, $builder);
    }

    public function getTesteeInstance(): ILegacyWidgetSettingsBuilder
    {
        return new LegacyWidgetSettingsBuilder();
    }

    #[Test]
    public function canBuild(): void
    {
        $widgetSettingsBuilder = $this->getTesteeInstance();

        $widgetSettings =
            $widgetSettingsBuilder
                ->withLeadingSpacer($this->getFrameMock())
                ->withTrailingSpacer($this->getFrameMock())
                ->withStylePattern($this->getStylePatternMock())
                ->withCharPattern($this->getCharPatternMock())
                ->build()
        ;

        self::assertInstanceOf(LegacyWidgetSettingsBuilder::class, $widgetSettingsBuilder);
        self::assertInstanceOf(LegacyWidgetSettings::class, $widgetSettings);
    }

    #[Test]
    public function throwsIfLeadingSpacerIsNotSet(): void
    {
        $exceptionClass = LogicException::class;
        $exceptionMessage = 'Leading spacer is not set.';

        $test = function (): void {
            $widgetSettingsBuilder = $this->getTesteeInstance();

            $widgetSettings =
                $widgetSettingsBuilder
                    ->withTrailingSpacer($this->getFrameMock())
                    ->withStylePattern($this->getStylePatternMock())
                    ->withCharPattern($this->getCharPatternMock())
                    ->build()
            ;

            self::assertInstanceOf(LegacyWidgetSettings::class, $widgetSettings);
        };

        $this->wrapExceptionTest(
            test: $test,
            exception: $exceptionClass,
            message: $exceptionMessage,
        );
    }

    #[Test]
    public function throwsIfTrailingSpacerIsNotSet(): void
    {
        $exceptionClass = LogicException::class;
        $exceptionMessage = 'Trailing spacer is not set.';

        $test = function (): void {
            $widgetSettingsBuilder = $this->getTesteeInstance();

            $widgetSettings =
                $widgetSettingsBuilder
                    ->withLeadingSpacer($this->getFrameMock())
                    ->withStylePattern($this->getStylePatternMock())
                    ->withCharPattern($this->getCharPatternMock())
                    ->build()
            ;

            self::assertInstanceOf(LegacyWidgetSettings::class, $widgetSettings);
        };

        $this->wrapExceptionTest(
            test: $test,
            exception: $exceptionClass,
            message: $exceptionMessage,
        );
    }

    #[Test]
    public function throwsIfStylePatternIsNotSet(): void
    {
        $exceptionClass = LogicException::class;
        $exceptionMessage = 'Style palette is not set.';

        $test = function (): void {
            $widgetSettingsBuilder = $this->getTesteeInstance();

            $widgetSettings =
                $widgetSettingsBuilder
                    ->withLeadingSpacer($this->getFrameMock())
                    ->withTrailingSpacer($this->getFrameMock())
                    ->withCharPattern($this->getCharPatternMock())
                    ->build()
            ;

            self::assertInstanceOf(LegacyWidgetSettings::class, $widgetSettings);
        };

        $this->wrapExceptionTest(
            test: $test,
            exception: $exceptionClass,
            message: $exceptionMessage,
        );
    }

    #[Test]
    public function throwsIfCharPatternIsNotSet(): void
    {
        $exceptionClass = LogicException::class;
        $exceptionMessage = 'Char palette is not set.';

        $test = function (): void {
            $widgetSettingsBuilder = $this->getTesteeInstance();

            $widgetSettings =
                $widgetSettingsBuilder
                    ->withLeadingSpacer($this->getFrameMock())
                    ->withTrailingSpacer($this->getFrameMock())
                    ->withStylePattern($this->getStylePatternMock())
                    ->build()
            ;

            self::assertInstanceOf(LegacyWidgetSettings::class, $widgetSettings);
        };

        $this->wrapExceptionTest(
            test: $test,
            exception: $exceptionClass,
            message: $exceptionMessage,
        );
    }
}
