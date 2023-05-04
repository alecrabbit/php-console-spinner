<?php

declare(strict_types=1);

namespace AlecRabbit\Tests\Unit\Spinner\Extras\Factory;

use AlecRabbit\Spinner\Extras\Factory\Contract\IHexColorToAnsiCodeConverterFactory;
use AlecRabbit\Spinner\Extras\Factory\HexColorToAnsiCodeConverterFactory;
use AlecRabbit\Tests\TestCase\TestCaseWithPrebuiltMocksAndStubs;
use PHPUnit\Framework\Attributes\Test;

final class HexColorToAnsiCodeConverterFactoryTest extends TestCaseWithPrebuiltMocksAndStubs
{
    #[Test]
    public function canBeCreated(): void
    {
        $factory = $this->getTesteeInstance();

        self::assertInstanceOf(HexColorToAnsiCodeConverterFactory::class, $factory);
    }

    public function getTesteeInstance(): IHexColorToAnsiCodeConverterFactory
    {
        return new HexColorToAnsiCodeConverterFactory();
    }
}
