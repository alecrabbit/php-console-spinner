<?php

declare(strict_types=1);

namespace AlecRabbit\Tests\Unit\Spinner\Core\Factory;

use AlecRabbit\Spinner\Contract\Option\OptionStyleMode;
use AlecRabbit\Spinner\Core\Color\HexColorToAnsiCodeConverter;
use AlecRabbit\Spinner\Core\Factory\Contract\IHexColorToAnsiCodeConverterFactory;
use AlecRabbit\Spinner\Core\Factory\HexColorToAnsiCodeConverterFactory;
use AlecRabbit\Spinner\Exception\InvalidArgumentException;
use AlecRabbit\Tests\TestCase\TestCaseWithPrebuiltMocksAndStubs;
use PHPUnit\Framework\Attributes\Test;

final class HexColorToAnsiCodeConverterFactoryTest extends TestCaseWithPrebuiltMocksAndStubs
{
    #[Test]
    public function canBeCreated(): void
    {
        $converterFactory = $this->getTesteeInstance();

        self::assertInstanceOf(HexColorToAnsiCodeConverterFactory::class, $converterFactory);
    }

    public function getTesteeInstance(): IHexColorToAnsiCodeConverterFactory
    {
        return new HexColorToAnsiCodeConverterFactory();
    }

    #[Test]
    public function canCreateConverter(): void
    {
        $converterFactory = $this->getTesteeInstance();

        $converter = $converterFactory->create(OptionStyleMode::ANSI4);
        self::assertInstanceOf(HexColorToAnsiCodeConverterFactory::class, $converterFactory);
        self::assertInstanceOf(HexColorToAnsiCodeConverter::class, $converter);
    }

    #[Test]
    public function throwsOnUnsupportedStyleMode(): void
    {
        $exceptionClass = InvalidArgumentException::class;
        $exceptionMessage = 'Unsupported style mode "NONE".';

        $test = function (): void {
            $converterFactory = $this->getTesteeInstance();

            $converter = $converterFactory->create(OptionStyleMode::NONE);
            self::assertInstanceOf(HexColorToAnsiCodeConverterFactory::class, $converterFactory);
            self::assertInstanceOf(HexColorToAnsiCodeConverter::class, $converter);
        };

        $this->wrapExceptionTest(
            test: $test,
            exceptionOrExceptionClass: $exceptionClass,
            exceptionMessage: $exceptionMessage,
        );
    }
}
