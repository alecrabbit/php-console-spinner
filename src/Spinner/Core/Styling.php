<?php declare(strict_types=1);

namespace AlecRabbit\Spinner\Core;

use AlecRabbit\Accessories\Circular;
use AlecRabbit\ConsoleColour\ConsoleColor;
use AlecRabbit\ConsoleColour\Terminal;

/**
 * Class Styling
 */
class Styling
{
    public const COLOR256_STYLES = '256_color_styles';
    public const COLOR_STYLES = 'color_styles';

    /** @var Circular */
    protected $styles;
    /** @var string */
    private $message;
    /** @var Circular */
    private $symbols;

    public function __construct(Circular $symbols, array $styles, string $message)
    {
        $this->symbols = $symbols;
        $this->message = $message;
        $this->styles = $this->makeStyles($styles);
    }

    protected function makeStyles(array $styles): Circular
    {
        $this->assertStyles($styles);
        $terminal = new Terminal();
        if ($terminal->supports256Color()) {
            return $this->circular256Color($styles);
        }
        if ($terminal->supportsColor()) {
            return $this->circularColor($styles);
        }
        return $this->circularNoColor($styles);
    }

    protected function assertStyles(array $styles): void
    {
        if (!\array_key_exists(self::COLOR256_STYLES, $styles)) {
            throw new \InvalidArgumentException('Styles array does not have ' . static::class . '::COLOR256_STYLES key');
        }
        if (!\array_key_exists(self::COLOR_STYLES, $styles)) {
            throw new \InvalidArgumentException('Styles array does not have ' . static::class . '::COLOR_STYLES key');
        }
    }

    protected function circular256Color(array $styles): Circular
    {
        return
            new Circular(
                array_map(
                    static function ($value) {
                        return ConsoleColor::ESC_CHAR . "[38;5;{$value}m%s" . ConsoleColor::ESC_CHAR . '[0m';
                    },
                    [
                        '203',
                        '209',
                        '215',
                        '221',
                        '227',
                        '191',
                        '155',
                        '119',
                        '83',
                        '84',
                        '85',
                        '86',
                        '87',
                        '81',
                        '75',
                        '69',
                        '63',
                        '99',
                        '135',
                        '171',
                        '207',
                        '206',
                        '205',
                        '204',
                    ]
                )
            );
    }

    protected function circularColor(array $styles): Circular
    {
        return new Circular(['96',]);
    }

    protected function circularNoColor(array $styles): Circular
    {
        return new Circular(['96',]);
    }

    public function spinner(): string
    {
        return sprintf((string)$this->styles->value(), (string)$this->symbols->value());
    }

    public function message(): string
    {
        return $this->message;
    }

}