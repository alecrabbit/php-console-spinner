<?php

declare(strict_types=1);

namespace AlecRabbit\Tests\Unit\Spinner\Extras\Factory;

use AlecRabbit\Spinner\Core\CharFrame;
use AlecRabbit\Spinner\Extras\Contract\IWidthMeasurer;
use AlecRabbit\Spinner\Extras\Factory\CharFrameFactory;
use AlecRabbit\Spinner\Extras\Factory\Contract\ICharFrameFactory;
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
        self::assertInstanceOf(CharFrame::class, $frameFactory->create(''));
    }
}
