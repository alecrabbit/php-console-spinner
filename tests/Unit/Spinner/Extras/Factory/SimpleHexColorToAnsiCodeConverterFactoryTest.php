<?php

declare(strict_types=1);

namespace AlecRabbit\Tests\Unit\Spinner\Extras\Factory;

use AlecRabbit\Spinner\Contract\Option\OptionStyleMode;
use AlecRabbit\Spinner\Exception\InvalidArgumentException;
use AlecRabbit\Spinner\Extras\Color\SimpleHexColorToAnsiCodeConverter;
use AlecRabbit\Spinner\Extras\Factory\Contract\IHexColorToAnsiCodeConverterFactory;
use AlecRabbit\Spinner\Extras\Factory\SimpleHexColorToAnsiCodeConverterFactory;
use AlecRabbit\Tests\TestCase\TestCaseWithPrebuiltMocksAndStubs;
use PHPUnit\Framework\Attributes\Test;

final class SimpleHexColorToAnsiCodeConverterFactoryTest extends TestCaseWithPrebuiltMocksAndStubs
{
    #[Test]
    public function canBeCreated(): void
    {
        $converterFactory = $this->getTesteeInstance();

        self::assertInstanceOf(SimpleHexColorToAnsiCodeConverterFactory::class, $converterFactory);
    }

    public function getTesteeInstance(): IHexColorToAnsiCodeConverterFactory
    {
        return new SimpleHexColorToAnsiCodeConverterFactory();
    }

    #[Test]
    public function canCreateConverter(): void
    {
        $converterFactory = $this->getTesteeInstance();

        $converter = $converterFactory->create(OptionStyleMode::ANSI4);
        self::assertInstanceOf(SimpleHexColorToAnsiCodeConverterFactory::class, $converterFactory);
        self::assertInstanceOf(SimpleHexColorToAnsiCodeConverter::class, $converter);
    }

    #[Test]
    public function throwsOnUnsupportedStyleMode(): void
    {
        $exceptionClass = InvalidArgumentException::class;
        $exceptionMessage = 'Unsupported style mode "NONE".';

        $test = function (): void {
            $converterFactory = $this->getTesteeInstance();

            $converter = $converterFactory->create(OptionStyleMode::NONE);
            self::assertInstanceOf(SimpleHexColorToAnsiCodeConverterFactory::class, $converterFactory);
            self::assertInstanceOf(SimpleHexColorToAnsiCodeConverter::class, $converter);
        };

        $this->wrapExceptionTest(
            test: $test,
            exception: $exceptionClass,
            message: $exceptionMessage,
        );
    }
}
