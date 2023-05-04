<?php

declare(strict_types=1);


namespace AlecRabbit\Tests\Unit\Spinner\Extras\Color;

use AlecRabbit\Spinner\Extras\Color\Style\StyleOptions;
use AlecRabbit\Spinner\Extras\Color\Style\StyleOptionsParser;
use AlecRabbit\Spinner\Extras\Contract\Style\IStyleOptionsParser;
use AlecRabbit\Spinner\Extras\Contract\Style\StyleOption;
use AlecRabbit\Tests\TestCase\TestCaseWithPrebuiltMocksAndStubs;
use PHPUnit\Framework\Attributes\Test;

final class StyleOptionsParserTest extends TestCaseWithPrebuiltMocksAndStubs
{
    private const SET = 'set';
    private const UNSET = 'unset';

    #[Test]
    public function canBeCreated(): void
    {
        $optionsParser = $this->getTesteeInstance();

        self::assertInstanceOf(StyleOptionsParser::class, $optionsParser);
    }

    protected function getTesteeInstance(): IStyleOptionsParser
    {
        return new StyleOptionsParser();
    }

    #[Test]
    public function canParseEmptyStyleOptions(): void
    {
        $optionsParser = $this->getTesteeInstance();

        self::assertInstanceOf(StyleOptionsParser::class, $optionsParser);

        $options = new StyleOptions();
        self::assertSame([], $optionsParser->parseOptions($options));
    }

    #[Test]
    public function canParseNullStyleOptions(): void
    {
        $optionsParser = $this->getTesteeInstance();

        self::assertInstanceOf(StyleOptionsParser::class, $optionsParser);

        $options = null;
        self::assertSame([], $optionsParser->parseOptions($options));
    }

    #[Test]
    public function canParseBoldStyleOptions(): void
    {
        $optionsParser = $this->getTesteeInstance();

        self::assertInstanceOf(StyleOptionsParser::class, $optionsParser);

        $options = new StyleOptions(StyleOption::BOLD);
        self::assertSame(
            [[self::SET => 1, self::UNSET => 22]],
            $optionsParser->parseOptions($options)
        );
    }

    #[Test]
    public function canParseMultipleStyleOptions(): void
    {
        $optionsParser = $this->getTesteeInstance();

        self::assertInstanceOf(StyleOptionsParser::class, $optionsParser);

        $options = new StyleOptions(
            StyleOption::BLINK,
            StyleOption::BOLD,
            StyleOption::HIDDEN,
        );
        self::assertSame(
            [
                [self::SET => 5, self::UNSET => 25],
                [self::SET => 1, self::UNSET => 22],
                [self::SET => 8, self::UNSET => 28],
            ],
            $optionsParser->parseOptions($options)
        );
    }
}
