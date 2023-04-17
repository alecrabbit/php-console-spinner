<?php

declare(strict_types=1);

namespace AlecRabbit\Tests\Unit\Spinner\Core\Factory;

use AlecRabbit\Spinner\Core\Color\Style\Style;
use AlecRabbit\Spinner\Core\Factory\Contract\IStyleFactory;
use AlecRabbit\Spinner\Core\Factory\StyleFactory;
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
        return
            new StyleFactory();
    }

    #[Test]
    public function canCreateStyle(): void
    {
        $styleFactory = $this->getTesteeInstance();

        self::assertInstanceOf(StyleFactory::class, $styleFactory);
        self::assertInstanceOf(Style::class, $styleFactory->fromString(''));
    }
}
