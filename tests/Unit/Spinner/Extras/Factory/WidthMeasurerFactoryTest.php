<?php

declare(strict_types=1);

namespace AlecRabbit\Tests\Unit\Spinner\Extras\Factory;

use AlecRabbit\Spinner\Extras\Factory\Contract\IWidthMeasurerFactory;
use AlecRabbit\Spinner\Extras\Factory\WidthMeasurerFactory;
use AlecRabbit\Spinner\Extras\WidthMeasurer;
use AlecRabbit\Tests\TestCase\TestCaseWithPrebuiltMocksAndStubs;
use PHPUnit\Framework\Attributes\Test;

final class WidthMeasurerFactoryTest extends TestCaseWithPrebuiltMocksAndStubs
{
    #[Test]
    public function canBeCreated(): void
    {
        $widthMeasurerFactory = $this->getTesteeInstance();

        self::assertInstanceOf(WidthMeasurerFactory::class, $widthMeasurerFactory);
    }

    public function getTesteeInstance(): IWidthMeasurerFactory
    {
        return new WidthMeasurerFactory();
    }

    #[Test]
    public function canWidthMeasurer(): void
    {
        $widthMeasurerFactory = $this->getTesteeInstance();

        self::assertInstanceOf(WidthMeasurerFactory::class, $widthMeasurerFactory);
        self::assertInstanceOf(WidthMeasurer::class, $widthMeasurerFactory->create());
    }
}
