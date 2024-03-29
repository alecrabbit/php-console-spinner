<?php

declare(strict_types=1);

namespace AlecRabbit\Tests\Spinner\Unit\Core\Widget\Builder;

use AlecRabbit\Spinner\Core\Contract\ITolerance;
use AlecRabbit\Spinner\Core\Revolver\Contract\IFrameRevolver;
use AlecRabbit\Spinner\Core\Widget\Builder\WidgetRevolverBuilder;
use AlecRabbit\Spinner\Core\Widget\Contract\IWidgetRevolverBuilder;
use AlecRabbit\Spinner\Core\Widget\WidgetRevolver;
use AlecRabbit\Spinner\Exception\LogicException;
use AlecRabbit\Tests\TestCase\TestCase;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\MockObject\MockObject;

final class WidgetRevolverBuilderTest extends TestCase
{
    #[Test]
    public function canBeInstantiated(): void
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
                ->withStyleRevolver($this->getFrameRevolverMock())
                ->withCharRevolver($this->getFrameRevolverMock())
                ->withTolerance($this->getToleranceMock())
                ->build()
        ;

        self::assertInstanceOf(WidgetRevolver::class, $widgetRevolver);
    }

    private function getFrameRevolverMock(): MockObject&IFrameRevolver
    {
        return $this->createMock(IFrameRevolver::class);
    }

    private function getToleranceMock(): MockObject&ITolerance
    {
        return $this->createMock(ITolerance::class);
    }

    #[Test]
    public function throwsOnBuildWithoutStyleRevolver(): void
    {
        $exceptionClass = LogicException::class;
        $exceptionMessage = 'Style revolver is not set.';

        $test = function (): void {
            $widgetRevolver = // intentional assignment
                $this->getTesteeInstance()
                    ->withCharRevolver($this->getFrameRevolverMock())
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
            $widgetRevolver = // intentional assignment
                $this->getTesteeInstance()
                    ->withStyleRevolver($this->getFrameRevolverMock())
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
