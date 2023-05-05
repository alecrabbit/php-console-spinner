<?php

declare(strict_types=1);


namespace AlecRabbit\Spinner\Extras\Color\Style;

use AlecRabbit\Spinner\Exception\InvalidArgumentException;
use AlecRabbit\Spinner\Extras\Contract\Style\IStyleOptions;
use AlecRabbit\Spinner\Extras\Contract\Style\IStyleOptionsParser;
use AlecRabbit\Spinner\Extras\Contract\Style\StyleOption;

final class StyleOptionsParser implements IStyleOptionsParser
{
    private const SET = 'set';
    private const UNSET = 'unset';

    public function parseOptions(?IStyleOptions $options): iterable
    {
        $optionCodes = [];
        if ($options) {
            foreach ($options as $option) {
                $optionCodes[] = self::getOptionCodes($option);
            }
        }
        return $optionCodes;
    }

    private static function getOptionCodes(StyleOption $option): array
    {
        return match ($option) {
            StyleOption::BOLD => [self::SET => 1, self::UNSET => 22],
            StyleOption::DIM => [self::SET => 2, self::UNSET => 22],
            StyleOption::ITALIC => [self::SET => 3, self::UNSET => 23],
            StyleOption::UNDERLINE => [self::SET => 4, self::UNSET => 24],
            StyleOption::BLINK => [self::SET => 5, self::UNSET => 25],
            StyleOption::REVERSE => [self::SET => 7, self::UNSET => 27],
            StyleOption::HIDDEN => [self::SET => 8, self::UNSET => 28],
            StyleOption::STRIKETHROUGH => [self::SET => 9, self::UNSET => 29],
            StyleOption::DOUBLE_UNDERLINE => [self::SET => 21, self::UNSET => 24],
            default => throw new InvalidArgumentException('Unknown option: ' . $option->name),
        };
    }
}
