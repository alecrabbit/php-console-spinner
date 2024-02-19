<?php

declare(strict_types=1);

namespace AlecRabbit\Tests\Spinner\Unit\Core\Widget\Builder;

use AlecRabbit\Spinner\Contract\IHasCharSequenceFrame;
use AlecRabbit\Spinner\Contract\IHasStyleSequenceFrame;
use AlecRabbit\Spinner\Contract\IInterval;
use AlecRabbit\Spinner\Core\Widget\Builder\NeoWidgetRevolverBuilder;
use AlecRabbit\Spinner\Core\Widget\Contract\INeoWidgetRevolverBuilder;
use AlecRabbit\Spinner\Core\Widget\NeoWidgetRevolver;
use AlecRabbit\Spinner\Exception\LogicException;
use AlecRabbit\Tests\TestCase\TestCase;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\MockObject\MockObject;

final class NeoWidgetRevolverBuilderTest extends TestCase
{
    #[Test]
    public function canBeInstantiated(): void
    {
        $widgetRevolverBuilder = $this->getTesteeInstance();

        self::assertInstanceOf(NeoWidgetRevolverBuilder::class, $widgetRevolverBuilder);
    }

    public function getTesteeInstance(): INeoWidgetRevolverBuilder
    {
        return new NeoWidgetRevolverBuilder();
    }

    #[Test]
    public function canBuild(): void
    {
        $widgetRevolverBuilder = $this->getTesteeInstance();

        self::assertInstanceOf(NeoWidgetRevolverBuilder::class, $widgetRevolverBuilder);

        $style = $this->getHasStyleSequenceFrameMock();

        $character = $this->getHasCharSequenceFrameMock();

        $interval = $this->getIntervalMock();

        $widgetRevolver =
            $widgetRevolverBuilder
                ->withStyle($style)
                ->withChar($character)
                ->withInterval($interval)
                ->build()
        ;

        self::assertInstanceOf(NeoWidgetRevolver::class, $widgetRevolver);
        self::assertSame($interval, $widgetRevolver->getInterval());
    }

    private function getHasStyleSequenceFrameMock(): MockObject&IHasStyleSequenceFrame
    {
        return $this->createMock(IHasStyleSequenceFrame::class);
    }

    private function getHasCharSequenceFrameMock(): MockObject&IHasCharSequenceFrame
    {
        return $this->createMock(IHasCharSequenceFrame::class);
    }

    private function getIntervalMock(): MockObject&IInterval
    {
        return $this->createMock(IInterval::class);
    }

    #[Test]
    public function throwsOnBuildWithoutStyle(): void
    {
        $exceptionClass = LogicException::class;
        $exceptionMessage = 'Style is not set.';

        $test = function (): void {
            $widgetRevolver = // intentional assignment
                $this->getTesteeInstance()
                    ->withChar($this->getHasCharSequenceFrameMock())
                    ->withInterval($this->getIntervalMock())
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
    public function throwsOnBuildWithoutChar(): void
    {
        $exceptionClass = LogicException::class;
        $exceptionMessage = 'Char is not set.';

        $test = function (): void {
            $widgetRevolver = // intentional assignment
                $this->getTesteeInstance()
                    ->withStyle($this->getHasStyleSequenceFrameMock())
                    ->withInterval($this->getIntervalMock())
                    ->build()
            ;
        };

        $this->wrapExceptionTest(
            test: $test,
            exception: $exceptionClass,
            message: $exceptionMessage,
        );
    }

    public function throwsOnBuildWithoutInterval(): void
    {
        $exceptionClass = LogicException::class;
        $exceptionMessage = 'Interval is not set.';

        $test = function (): void {
            $widgetRevolver = // intentional assignment
                $this->getTesteeInstance()
                    ->withChar($this->getHasCharSequenceFrameMock())
                    ->withStyle($this->getHasStyleSequenceFrameMock())
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
