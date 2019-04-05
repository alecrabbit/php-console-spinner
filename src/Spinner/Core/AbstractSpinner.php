<?php declare(strict_types=1);

namespace AlecRabbit\Spinner\Core;

use AlecRabbit\Accessories\Circular;
use AlecRabbit\ConsoleColour\ConsoleColor;
use AlecRabbit\ConsoleColour\Terminal;
use AlecRabbit\Spinner\Contracts\SpinnerInterface;

abstract class AbstractSpinner implements SpinnerInterface
{
    protected const ESC = ConsoleColor::ESC_CHAR;
    protected const PADDING_STR = ' ';

    /** @var Circular */
    protected $spinnerSymbols;
    /** @var null|Circular */
    protected $styles;
    /** @var string */
    protected $message;
    /** @var string */
    protected $resetStr;
    /** @var \Closure */
    protected $style;


    public function __construct(
        string $message = SpinnerInterface::DEFAULT_MESSAGE,
        string $prefix = SpinnerInterface::DEFAULT_PREFIX,
        string $suffix = SpinnerInterface::DEFAULT_SUFFIX
    ) {
        $this->spinnerSymbols = $this->getSymbols();
        $this->styles = $this->getStyles();

        $this->message = $this->refineStr($message, $prefix, $suffix);
        $strLen = strlen($this->message . static::PADDING_STR) + 2;
        $this->resetStr = self::ESC . "[{$strLen}D";
        $this->style = $this->getStyle();
    }

    /**
     * @return Circular
     */
    abstract protected function getSymbols(): Circular;

    protected function getStyles(): ?Circular
    {
        $terminal = new Terminal();
        if ($terminal->supports256Color()) {
            return new Circular([
                '38;5;197',
                '38;5;198',
                '38;5;199',
                '38;5;200',
                '38;5;201',
                '38;5;202',
                '38;5;203',
                '38;5;204',
                '38;5;205',
            ]);
        }
        // @codeCoverageIgnoreStart
        if ($terminal->supportsColor()) {
            return new Circular([
                '96',
            ]);
        }
        return null;
        // @codeCoverageIgnoreEnd
    }

    /**
     * @param string $str
     * @param string $prefix
     * @param string $suffix
     * @return string
     */
    protected function refineStr(string $str, string $prefix, string $suffix): string
    {
        return $prefix . $str . $suffix;
    }

    /**
     * @return \Closure
     */
    protected function getStyle(): \Closure
    {
        if (null === $this->styles) {
            return
                function (): string {
                    $value = (string)$this->spinnerSymbols->value();
                    return static::PADDING_STR . $value;
                };
        }
        return
            function (): string {
                $symbol = (string)$this->spinnerSymbols->value();
                $style = $this->styles ? (string)$this->styles->value() : '';
                return
                    static::PADDING_STR .
                    self::ESC .
                    "[{$style}m{$symbol}" .
                    self::ESC . '[0m';
            };
    }

    /** {@inheritDoc} */
    public function begin(): string
    {
        return $this->work() . $this->resetStr;
    }

    protected function work(): string
    {
        return ($this->style)() . $this->message;
    }

    /** {@inheritDoc} */
    public function spin(): string
    {
        return $this->work() . $this->resetStr;
    }

    /** {@inheritDoc} */
    public function end(): string
    {
        return $this->resetStr . self::ESC . '[K';
    }
}
