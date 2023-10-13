<?php

declare(strict_types=1);

namespace AlecRabbit\Tests\Unit\Spinner\Core\Widget\Builder;

use AlecRabbit\Spinner\Core\Widget\Builder\WidgetCompositeBuilder;
use AlecRabbit\Spinner\Core\Widget\Contract\IWidgetCompositeBuilder;
use AlecRabbit\Spinner\Core\Widget\WidgetComposite;
use AlecRabbit\Tests\TestCase\TestCaseWithPrebuiltMocksAndStubs;
use LogicException;
use PHPUnit\Framework\Attributes\Test;

final class WidgetCompositeBuilderTest extends TestCaseWithPrebuiltMocksAndStubs
{
    #[Test]
    public function canBeInstantiated(): void
    {
        $widgetBuilder = $this->getTesteeInstance();

        self::assertInstanceOf(WidgetCompositeBuilder::class, $widgetBuilder);
    }

    public function getTesteeInstance(): IWidgetCompositeBuilder
    {
        return new WidgetCompositeBuilder();
    }

    #[Test]
    public function canBuild(): void
    {
        $widgetBuilder = $this->getTesteeInstance();

        self::assertInstanceOf(WidgetCompositeBuilder::class, $widgetBuilder);

        $widgetComposite =
            $widgetBuilder
                ->withWidgetRevolver($this->getWidgetRevolverMock())
                ->withLeadingSpacer($this->getFrameMock())
                ->withTrailingSpacer($this->getFrameMock())
                ->build()
        ;

        self::assertInstanceOf(WidgetComposite::class, $widgetComposite);
    }

    #[Test]
    public function throwsOnBuildWithoutRevolver(): void
    {
        $exceptionClass = LogicException::class;
        $exceptionMessage = 'Revolver is not set.';

        $test = function (): void {
            $widgetBuilder = $this->getTesteeInstance();

            $widget =
                $widgetBuilder
                    ->withLeadingSpacer($this->getFrameMock())
                    ->withTrailingSpacer($this->getFrameMock())
                    ->build()
            ;

            self::assertInstanceOf(WidgetComposite::class, $widget);
        };

        $this->wrapExceptionTest(
            test: $test,
            exception: $exceptionClass,
            message: $exceptionMessage,
        );
    }

    #[Test]
    public function throwsOnBuildWithoutLeadingSpacer(): void
    {
        $exceptionClass = LogicException::class;
        $exceptionMessage = 'Leading spacer is not set.';

        $test = function (): void {
            $widgetBuilder = $this->getTesteeInstance();

            $widget =
                $widgetBuilder
                    ->withWidgetRevolver($this->getRevolverMock())
                    ->withTrailingSpacer($this->getFrameMock())
                    ->build()
            ;

            self::assertInstanceOf(WidgetComposite::class, $widget);
        };

        $this->wrapExceptionTest(
            test: $test,
            exception: $exceptionClass,
            message: $exceptionMessage,
        );
    }

    #[Test]
    public function throwsOnBuildWithoutTrailingSpacer(): void
    {
        $exceptionClass = LogicException::class;
        $exceptionMessage = 'Trailing spacer is not set.';

        $test = function (): void {
            $widgetBuilder = $this->getTesteeInstance();

            $widget =
                $widgetBuilder
                    ->withWidgetRevolver($this->getRevolverMock())
                    ->withLeadingSpacer($this->getFrameMock())
                    ->build()
            ;

            self::assertInstanceOf(WidgetComposite::class, $widget);
        };

        $this->wrapExceptionTest(
            test: $test,
            exception: $exceptionClass,
            message: $exceptionMessage,
        );
    }
}