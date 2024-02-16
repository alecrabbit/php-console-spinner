<?php

declare(strict_types=1);

namespace AlecRabbit\Tests\Spinner\Unit\Core\Widget\Builder;

use AlecRabbit\Spinner\Contract\IInterval;
use AlecRabbit\Spinner\Core\Contract\IIntervalComparator;
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

    public function getTesteeInstance(
        ?IIntervalComparator $intervalComparator = null,
    ): IWidgetRevolverBuilder {
        return new WidgetRevolverBuilder(
            intervalComparator: $intervalComparator ?? $this->getIntervalComparatorMock(),
        );
    }

    private function getIntervalComparatorMock(): MockObject&IIntervalComparator
    {
        return $this->createMock(IIntervalComparator::class);
    }

    #[Test]
    public function canBuild(): void
    {
        $widgetRevolverBuilder = $this->getTesteeInstance();

        self::assertInstanceOf(WidgetRevolverBuilder::class, $widgetRevolverBuilder);

        $styleInterval = $this->getIntervalMock();
        $characterInterval = $this->getIntervalMock();

        $style = $this->getFrameRevolverMock();
        $style
            ->expects(self::once())
            ->method('getInterval')
            ->willReturn($styleInterval)
        ;

        $character = $this->getFrameRevolverMock();
        $character
            ->expects(self::once())
            ->method('getInterval')
            ->willReturn($characterInterval)
        ;

        $intervalComparator = $this->getIntervalComparatorMock();
        $intervalComparator
            ->expects(self::once())
            ->method('smallest')
            ->with($styleInterval, $characterInterval)
            ->willReturn($styleInterval)
        ;

        $widgetRevolver =
            $widgetRevolverBuilder
                ->withStyleRevolver($style)
                ->withCharRevolver($character)
                ->withIntervalComparator($intervalComparator)
                ->build()
        ;

        self::assertInstanceOf(WidgetRevolver::class, $widgetRevolver);
    }

    private function getIntervalMock(): MockObject&IInterval
    {
        return $this->createMock(IInterval::class);
    }

    private function getFrameRevolverMock(): MockObject&IFrameRevolver
    {
        return $this->createMock(IFrameRevolver::class);
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
                    ->withIntervalComparator($this->getIntervalComparatorMock())
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
                    ->withIntervalComparator($this->getIntervalComparatorMock())
                    ->build()
            ;
        };

        $this->wrapExceptionTest(
            test: $test,
            exception: $exceptionClass,
            message: $exceptionMessage,
        );
    }

    private function getToleranceMock(): MockObject&ITolerance
    {
        return $this->createMock(ITolerance::class);
    }
}
