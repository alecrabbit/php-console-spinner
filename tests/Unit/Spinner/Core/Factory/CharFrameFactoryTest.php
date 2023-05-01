<?php

declare(strict_types=1);

namespace AlecRabbit\Tests\Unit\Spinner\Core\Factory;

use AlecRabbit\Spinner\Core\Contract\IWidthMeasurer;
use AlecRabbit\Spinner\Core\Factory\Contract\ICharFrameFactory;
use AlecRabbit\Spinner\Core\Factory\CharFrameFactory;
use AlecRabbit\Spinner\Core\CharFrame;
use AlecRabbit\Tests\TestCase\TestCaseWithPrebuiltMocksAndStubs;
use PHPUnit\Framework\Attributes\Test;

final class CharFrameFactoryTest extends TestCaseWithPrebuiltMocksAndStubs
{
    #[Test]
    public function canBeCreated(): void
    {
        $frameFactory = $this->getTesteeInstance();

        self::assertInstanceOf(CharFrameFactory::class, $frameFactory);
    }

    public function getTesteeInstance(
        ?IWidthMeasurer $widthMeasurer = null,
    ): ICharFrameFactory {
        return new CharFrameFactory(
            widthMeasurer: $widthMeasurer ?? $this->getWidthMeasurerMock(),
        );
    }

    #[Test]
    public function canCreate(): void
    {
        $frameFactory = $this->getTesteeInstance();

        self::assertInstanceOf(CharFrameFactory::class, $frameFactory);
        self::assertInstanceOf(CharFrame::class, $frameFactory->create('', 0));
        self::assertInstanceOf(CharFrame::class, $frameFactory->create(''));
    }
}
