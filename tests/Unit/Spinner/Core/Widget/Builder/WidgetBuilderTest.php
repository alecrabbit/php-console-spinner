<?php

declare(strict_types=1);

namespace AlecRabbit\Tests\Unit\Spinner\Core\Widget\Builder;

use AlecRabbit\Spinner\Contract\IFrame;
use AlecRabbit\Spinner\Core\Widget\Builder\WidgetBuilder;
use AlecRabbit\Spinner\Core\Widget\Contract\IWidgetBuilder;
use AlecRabbit\Spinner\Core\Widget\Contract\IWidgetRevolver;
use AlecRabbit\Spinner\Core\Widget\Widget;
use AlecRabbit\Tests\TestCase\TestCase;
use LogicException;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\MockObject\MockObject;

final class WidgetBuilderTest extends TestCase
{
    #[Test]
    public function canBeInstantiated(): void
    {
        $widgetBuilder = $this->getTesteeInstance();

        self::assertInstanceOf(WidgetBuilder::class, $widgetBuilder);
    }

    public function getTesteeInstance(): IWidgetBuilder
    {
        return new WidgetBuilder();
    }

    #[Test]
    public function canBuild(): void
    {
        $widgetBuilder = $this->getTesteeInstance();

        self::assertInstanceOf(WidgetBuilder::class, $widgetBuilder);

        $widgetComposite =
            $widgetBuilder
                ->withWidgetRevolver($this->getWidgetRevolverMock())
                ->withLeadingSpacer($this->getFrameMock())
                ->withTrailingSpacer($this->getFrameMock())
                ->build()
        ;

        self::assertInstanceOf(Widget::class, $widgetComposite);
    }

    protected function getWidgetRevolverMock(): MockObject&IWidgetRevolver
    {
        return $this->createMock(IWidgetRevolver::class);
    }

    protected function getFrameMock(): MockObject&IFrame
    {
        return $this->createMock(IFrame::class);
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

            self::assertInstanceOf(Widget::class, $widget);
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
                    ->withWidgetRevolver($this->getWidgetRevolverMock())
                    ->withTrailingSpacer($this->getFrameMock())
                    ->build()
            ;

            self::assertInstanceOf(Widget::class, $widget);
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
                    ->withWidgetRevolver($this->getWidgetRevolverMock())
                    ->withLeadingSpacer($this->getFrameMock())
                    ->build()
            ;

            self::assertInstanceOf(Widget::class, $widget);
        };

        $this->wrapExceptionTest(
            test: $test,
            exception: $exceptionClass,
            message: $exceptionMessage,
        );
    }
}
