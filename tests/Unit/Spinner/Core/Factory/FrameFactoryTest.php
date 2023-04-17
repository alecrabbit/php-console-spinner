<?php

declare(strict_types=1);

namespace AlecRabbit\Tests\Unit\Spinner\Core\Factory;

use AlecRabbit\Spinner\Core\Contract\IWidthMeasurer;
use AlecRabbit\Spinner\Core\Factory\Contract\IFrameFactory;
use AlecRabbit\Spinner\Core\Factory\FrameFactory;
use AlecRabbit\Spinner\Core\Frame;
use AlecRabbit\Tests\TestCase\TestCaseWithPrebuiltMocksAndStubs;
use PHPUnit\Framework\Attributes\Test;

final class FrameFactoryTest extends TestCaseWithPrebuiltMocksAndStubs
{
    #[Test]
    public function canBeCreated(): void
    {
        $frameFactory = $this->getTesteeInstance();

        self::assertInstanceOf(FrameFactory::class, $frameFactory);
    }

    public function getTesteeInstance(
        ?IWidthMeasurer $widthMeasurer = null,
    ): IFrameFactory {
        return
            new FrameFactory(
                widthMeasurer: $widthMeasurer ?? $this->getWidthMeasurerMock(),
            );
    }

    #[Test]
    public function canCreate(): void
    {
        $frameFactory = $this->getTesteeInstance();

        self::assertInstanceOf(FrameFactory::class, $frameFactory);
        self::assertInstanceOf(Frame::class, $frameFactory->create('', 0));
        self::assertInstanceOf(Frame::class, $frameFactory->create(''));
    }
    #[Test]
    public function canCreateEmptyFrame(): void
    {
        $frameFactory = $this->getTesteeInstance();

        self::assertInstanceOf(FrameFactory::class, $frameFactory);
        $frame = $frameFactory->createEmpty();
        self::assertInstanceOf(Frame::class, $frame);
        self::assertSame('', $frame->sequence());
        self::assertSame(0, $frame->width());
    }
}
