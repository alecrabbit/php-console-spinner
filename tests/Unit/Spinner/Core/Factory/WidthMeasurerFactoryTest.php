<?php

declare(strict_types=1);

namespace AlecRabbit\Tests\Unit\Spinner\Core\Factory;

use AlecRabbit\Spinner\Core\Factory\Contract\IWidthMeasurerFactory;
use AlecRabbit\Spinner\Core\Factory\WidthMeasurerFactory;
use AlecRabbit\Spinner\Core\WidthMeasurer;
use AlecRabbit\Tests\TestCase\TestCaseWithPrebuiltMocks;
use PHPUnit\Framework\Attributes\Test;

final class WidthMeasurerFactoryTest extends TestCaseWithPrebuiltMocks
{
    #[Test]
    public function canBeCreated(): void
    {
        $widthMeasurerFactory = $this->getTesteeInstance();

        self::assertInstanceOf(WidthMeasurerFactory::class, $widthMeasurerFactory);
    }

    public function getTesteeInstance(): IWidthMeasurerFactory
    {
        return
            new WidthMeasurerFactory();
    }

    #[Test]
    public function canWidthMeasurer(): void
    {
        $widthMeasurerFactory = $this->getTesteeInstance();

        self::assertInstanceOf(WidthMeasurerFactory::class, $widthMeasurerFactory);
        self::assertInstanceOf(WidthMeasurer::class, $widthMeasurerFactory->create());
    }
}
