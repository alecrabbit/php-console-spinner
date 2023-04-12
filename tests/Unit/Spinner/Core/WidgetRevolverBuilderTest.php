<?php

declare(strict_types=1);

namespace AlecRabbit\Tests\Unit\Spinner\Core;

use AlecRabbit\Spinner\Core\Widget\Contract\IWidgetRevolverBuilder;
use AlecRabbit\Spinner\Core\Widget\Widget;
use AlecRabbit\Spinner\Core\Widget\WidgetRevolver;
use AlecRabbit\Spinner\Core\Widget\WidgetRevolverBuilder;
use AlecRabbit\Spinner\Exception\LogicException;
use AlecRabbit\Tests\TestCase\TestCaseWithPrebuiltMocksAndStubs;
use PHPUnit\Framework\Attributes\Test;

final class WidgetRevolverBuilderTest extends TestCaseWithPrebuiltMocksAndStubs
{
    #[Test]
    public function canBeCreated(): void
    {
        $widgetRevolverBuilder = $this->getTesteeInstance();

        self::assertInstanceOf(WidgetRevolverBuilder::class, $widgetRevolverBuilder);
    }

    public function getTesteeInstance(): IWidgetRevolverBuilder
    {
        return
            new WidgetRevolverBuilder();
    }

    #[Test]
    public function canBuild(): void
    {
        $widgetRevolverBuilder = $this->getTesteeInstance();

        self::assertInstanceOf(WidgetRevolverBuilder::class, $widgetRevolverBuilder);

        $widgetRevolver =
            $widgetRevolverBuilder
                ->withStyleRevolver($this->getRevolverMock())
                ->withCharRevolver($this->getRevolverMock())
                ->build()
        ;

        self::assertInstanceOf(WidgetRevolver::class, $widgetRevolver);
    }

    #[Test]
    public function throwsOnBuildWithoutStyleRevolver(): void
    {
        $exceptionClass = LogicException::class;
        $exceptionMessage = 'Style revolver is not set.';

        $test = function () {
            $widgetRevolver =
                $this->getTesteeInstance()
                    ->withCharRevolver($this->getRevolverMock())
                    ->build()
            ;

            self::assertInstanceOf(Widget::class, $widgetRevolver);
        };

        $this->testExceptionWrapper(
            exceptionClass: $exceptionClass,
            exceptionMessage: $exceptionMessage,
            test: $test,
            method: __METHOD__,
        );
    }
    #[Test]
    public function throwsOnBuildWithoutCharRevolver(): void
    {
        $exceptionClass = LogicException::class;
        $exceptionMessage = 'Character revolver is not set.';

        $test = function () {
            $widgetRevolver =
                $this->getTesteeInstance()
                    ->withStyleRevolver($this->getRevolverMock())
                    ->build()
            ;

            self::assertInstanceOf(Widget::class, $widgetRevolver);
        };

        $this->testExceptionWrapper(
            exceptionClass: $exceptionClass,
            exceptionMessage: $exceptionMessage,
            test: $test,
            method: __METHOD__,
        );
    }
}
