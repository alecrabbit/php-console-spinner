<?php

declare(strict_types=1);

namespace AlecRabbit\Tests\Unit\Spinner\Extras\Factory;

use AlecRabbit\Spinner\Extras\Color\Style\Style;
use AlecRabbit\Spinner\Extras\Factory\Contract\IStyleFactory;
use AlecRabbit\Spinner\Extras\Factory\StyleFactory;
use AlecRabbit\Tests\TestCase\TestCaseWithPrebuiltMocksAndStubs;
use PHPUnit\Framework\Attributes\Test;

final class StyleFactoryTest extends TestCaseWithPrebuiltMocksAndStubs
{
    #[Test]
    public function canBeCreated(): void
    {
        $styleFactory = $this->getTesteeInstance();

        self::assertInstanceOf(StyleFactory::class, $styleFactory);
    }

    public function getTesteeInstance(): IStyleFactory
    {
        return new StyleFactory();
    }

    #[Test]
    public function canCreateStyle(): void
    {
        $styleFactory = $this->getTesteeInstance();

        self::assertInstanceOf(StyleFactory::class, $styleFactory);
        self::assertInstanceOf(Style::class, $styleFactory->fromString(''));
    }
}
