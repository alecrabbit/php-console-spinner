<?php

declare(strict_types=1);

namespace AlecRabbit\Tests\Unit\Spinner\Core\Widget;

use AlecRabbit\Spinner\Core\Revolver\Contract\IRevolver;
use AlecRabbit\Spinner\Core\Widget\Contract\IWidgetRevolver;
use AlecRabbit\Spinner\Core\Widget\WidgetRevolver;
use AlecRabbit\Tests\TestCase\TestCaseWithPrebuiltMocksAndStubs;
use PHPUnit\Framework\Attributes\Test;

final class WidgetRevolverTest extends TestCaseWithPrebuiltMocksAndStubs
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
        ?int $deltaTolerance = null,
    ): IWidgetRevolver {
        return
            new WidgetRevolver(
                style: $style ?? $this->getRevolverMock(),
                character: $character ?? $this->getRevolverMock(),
                deltaTolerance: $deltaTolerance ?? 0,
            );
    }

    #[Test]
    public function canGetInterval(): void
    {
        $characterInterval = $this->getIntervalMock();
        $interval = $this->getIntervalMock();
        $interval
            ->expects(self::once())
            ->method('smallest')
            ->with($characterInterval)
            ->willReturnSelf()
        ;

        $style = $this->getRevolverMock();
        $style
            ->expects(self::once())
            ->method('getInterval')
            ->willReturn($interval)
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
        self::assertSame($interval, $revolver->getInterval());
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
}
