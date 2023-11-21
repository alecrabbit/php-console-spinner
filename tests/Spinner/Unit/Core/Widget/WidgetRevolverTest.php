<?php

declare(strict_types=1);

namespace AlecRabbit\Tests\Spinner\Unit\Core\Widget;

use AlecRabbit\Spinner\Contract\IFrame;
use AlecRabbit\Spinner\Contract\IInterval;
use AlecRabbit\Spinner\Core\Contract\ITolerance;
use AlecRabbit\Spinner\Core\Revolver\Contract\IRevolver;
use AlecRabbit\Spinner\Core\Widget\Contract\IWidgetRevolver;
use AlecRabbit\Spinner\Core\Widget\WidgetRevolver;
use AlecRabbit\Tests\TestCase\TestCase;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\MockObject\MockObject;

final class WidgetRevolverTest extends TestCase
{
    #[Test]
    public function canBeInstantiated(): void
    {
        $revolver = $this->getTesteeInstance();

        self::assertInstanceOf(WidgetRevolver::class, $revolver);
    }

    public function getTesteeInstance(
        ?IRevolver $style = null,
        ?IRevolver $character = null,
        ?ITolerance $tolerance = null,
    ): IWidgetRevolver {
        return
            new WidgetRevolver(
                style: $style ?? $this->getRevolverMock(),
                character: $character ?? $this->getRevolverMock(),
                tolerance: $tolerance ?? $this->getToleranceMock(),
            );
    }

    protected function getRevolverMock(): MockObject&IRevolver
    {
        return $this->createMock(IRevolver::class);
    }

    private function getToleranceMock(): MockObject&ITolerance
    {
        return $this->createMock(ITolerance::class);
    }

    #[Test]
    public function canGetInterval(): void
    {
        $styleInterval = $this->getIntervalMock();
        $characterInterval = $this->getIntervalMock();

        $style = $this->getRevolverMock();
        $style
            ->expects(self::once())
            ->method('getInterval')
            ->willReturn($styleInterval)
        ;

        $character = $this->getRevolverMock();
        $character
            ->expects(self::once())
            ->method('getInterval')
            ->willReturn($characterInterval)
        ;
        $revolver = $this->getTesteeInstance(
            style: $style,
            character: $character,
        );
        self::assertSame($styleInterval, $revolver->getInterval());
    }

    protected function getIntervalMock(): MockObject&IInterval
    {
        return $this->createMock(IInterval::class);
    }

    #[Test]
    public function canGetFrame(): void
    {
        $dt = 10.0;
        $styleFrame = $this->getFrameMock();
        $styleFrame
            ->expects(self::once())
            ->method('sequence')
            ->willReturn('-%s-')
        ;
        $styleFrame
            ->expects(self::once())
            ->method('width')
            ->willReturn(2)
        ;
        $characterFrame = $this->getFrameMock();
        $characterFrame
            ->expects(self::once())
            ->method('sequence')
            ->willReturn('c')
        ;
        $characterFrame
            ->expects(self::once())
            ->method('width')
            ->willReturn(1)
        ;

        $style = $this->getRevolverMock();
        $style
            ->expects(self::once())
            ->method('getFrame')
            ->with($dt)
            ->willReturn($styleFrame)
        ;

        $character = $this->getRevolverMock();
        $character
            ->expects(self::once())
            ->method('getFrame')
            ->with($dt)
            ->willReturn($characterFrame)
        ;

        $revolver = $this->getTesteeInstance(
            style: $style,
            character: $character,
        );

        $result = $revolver->getFrame($dt);

        self::assertEquals('-c-', $result->sequence());
        self::assertEquals(3, $result->width());
    }

    protected function getFrameMock(): MockObject&IFrame
    {
        return $this->createMock(IFrame::class);
    }
}
