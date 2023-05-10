<?php

declare(strict_types=1);

namespace AlecRabbit\Tests\Unit\Spinner\Extras\Factory;

use AlecRabbit\Spinner\Core\StyleFrame;
use AlecRabbit\Spinner\Extras\Contract\IWidthMeasurer;
use AlecRabbit\Spinner\Extras\Factory\Contract\IStyleFrameFactory;
use AlecRabbit\Spinner\Extras\Factory\StyleFrameFactory;
use AlecRabbit\Tests\TestCase\TestCaseWithPrebuiltMocksAndStubs;
use PHPUnit\Framework\Attributes\Test;

final class StyleFrameFactoryTest extends TestCaseWithPrebuiltMocksAndStubs
{
    #[Test]
    public function canBeCreated(): void
    {
        $frameFactory = $this->getTesteeInstance();

        self::assertInstanceOf(StyleFrameFactory::class, $frameFactory);
    }

    public function getTesteeInstance(
        ?IWidthMeasurer $widthMeasurer = null,
    ): IStyleFrameFactory {
        return new StyleFrameFactory(
            widthMeasurer: $widthMeasurer ?? $this->getWidthMeasurerMock(),
        );
    }

    #[Test]
    public function canCreate(): void
    {
        $frameFactory = $this->getTesteeInstance();

        self::assertInstanceOf(StyleFrameFactory::class, $frameFactory);
        self::assertInstanceOf(StyleFrame::class, $frameFactory->create('%s', 0));
    }

    #[Test]
    public function canCreateIfWidthNotProvided(): void
    {
        $widthMeasurer = $this->getWidthMeasurerMock();
        $widthMeasurer
            ->expects(self::once())
            ->method('measureWidth')
            ->with('')
            ->willReturn(0)
        ;

        $frameFactory = $this->getTesteeInstance(
            widthMeasurer: $widthMeasurer
        );

        self::assertInstanceOf(StyleFrameFactory::class, $frameFactory);

        $frame = $frameFactory->create('%s');

        self::assertInstanceOf(StyleFrame::class, $frame);
        self::assertEquals(0, $frame->width());
    }
}
