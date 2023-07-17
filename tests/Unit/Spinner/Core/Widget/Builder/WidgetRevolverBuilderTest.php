<?php

declare(strict_types=1);

namespace AlecRabbit\Tests\Unit\Spinner\Core\Widget\Builder;

use AlecRabbit\Spinner\Core\Widget\Builder\WidgetRevolverBuilder;
use AlecRabbit\Spinner\Core\Widget\Contract\IWidgetRevolverBuilder;
use AlecRabbit\Spinner\Core\Widget\WidgetRevolver;
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
        return new WidgetRevolverBuilder();
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
                ->withTolerance(10)
                ->build()
        ;

        self::assertInstanceOf(WidgetRevolver::class, $widgetRevolver);
    }

    #[Test]
    public function throwsOnBuildWithoutStyleRevolver(): void
    {
        $exceptionClass = LogicException::class;
        $exceptionMessage = 'Style revolver is not set.';

        $test = function (): void {
            $widgetRevolver =
                $this->getTesteeInstance()
                    ->withCharRevolver($this->getRevolverMock())
                    ->build()
            ;
        };

        $this->wrapExceptionTest(
            test: $test,
            exception: $exceptionClass,
            message: $exceptionMessage,
        );
    }

    #[Test]
    public function throwsOnBuildWithoutCharRevolver(): void
    {
        $exceptionClass = LogicException::class;
        $exceptionMessage = 'Character revolver is not set.';

        $test = function (): void {
            $widgetRevolver =
                $this->getTesteeInstance()
                    ->withStyleRevolver($this->getRevolverMock())
                    ->build()
            ;
        };

        $this->wrapExceptionTest(
            test: $test,
            exception: $exceptionClass,
            message: $exceptionMessage,
        );
    }
}
