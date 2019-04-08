<?php declare(strict_types=1);

namespace AlecRabbit\Spinner\Core;

use AlecRabbit\Accessories\Circular;
use AlecRabbit\ConsoleColour\ConsoleColor;
use AlecRabbit\ConsoleColour\Terminal;
use AlecRabbit\Spinner\Contracts\SpinnerInterface;

abstract class AbstractSpinner implements SpinnerInterface
{
    protected const ESC = ConsoleColor::ESC_CHAR;
    protected const ERASING_SHIFT = 1;

    /** @var Circular */
    protected $spinnerSymbols;
    /** @var string */
    protected $message;
    /** @var string */
    protected $moveBackStr;
    /** @var \Closure */
    protected $style;
    /** @var string */
    protected $paddingStr;
    /** @var string */
    protected $eraseBySpacesStr;
    /** @var Styling */
    protected $styled;


    public function __construct(
        ?string $message = null,
        ?string $prefix = null,
        ?string $suffix = null,
        ?string $paddingStr = null
    ) {
        $this->spinnerSymbols = $this->getSymbols();
        $this->paddingStr = $paddingStr ?? SpinnerInterface::PADDING_NEXT_LINE;
        $this->message = $this->refineMessage($message, $prefix, $suffix);
        $this->setFields();
//        $this->style = $this->getStyle();
        $this->styled = new Styling($this->getSymbols(), $this->getStyles(), $this->message);
    }

    /**
     * @return Circular
     */
    abstract protected function getSymbols(): Circular;

    protected function getStyles(): array
    {
        return [
            Styling::COLOR256_SPINNER_STYLES => [
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
            ],
            Styling::COLOR_SPINNER_STYLES => ['96'],
        ];
    }

    /**
     * @param null|string $message
     * @param null|string $prefix
     * @param null|string $suffix
     * @return string
     */
    protected function refineMessage(?string $message, ?string $prefix, ?string $suffix): string
    {
        $message = ucfirst($message ?? SpinnerInterface::DEFAULT_MESSAGE);
        $prefix = $prefix ?? SpinnerInterface::DEFAULT_PREFIX;
        $suffix = $suffix ?? (empty($message) ? '' : SpinnerInterface::DEFAULT_SUFFIX);
        return $prefix . $message . $suffix;
    }

    protected function setFields(): void
    {
        $strLen = strlen($this->message . $this->paddingStr) + static::ERASING_SHIFT;
        $this->moveBackStr = self::ESC . "[{$strLen}D";
        $this->eraseBySpacesStr = str_repeat(' ', $strLen);
    }

    public function inline(bool $inline): SpinnerInterface
    {
        $this->paddingStr = $inline ? SpinnerInterface::PADDING_INLINE : SpinnerInterface::PADDING_NEXT_LINE;
        $this->setFields();

        return $this;
    }

    /** {@inheritDoc} */
    public function begin(): string
    {
        return $this->spin();
    }

    /** {@inheritDoc} */
    public function spin(): string
    {
        return $this->paddingStr . $this->styled->spinner() . $this->styled->message() . $this->moveBackStr;
    }

    /** {@inheritDoc} */
    public function end(): string
    {
        return $this->erase();
    }

    /** {@inheritDoc} */
    public function erase(): string
    {
        return $this->eraseBySpacesStr . $this->moveBackStr;
    }
}
