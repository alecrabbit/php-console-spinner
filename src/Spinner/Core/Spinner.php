<?php declare(strict_types=1);

namespace AlecRabbit\Spinner\Core;

use AlecRabbit\Accessories\Circular;
use AlecRabbit\Accessories\Pretty;
use AlecRabbit\Cli\Tools\Cursor;
use AlecRabbit\Spinner\Core\Contracts\SettingsInterface;
use AlecRabbit\Spinner\Core\Contracts\SpinnerInterface;
use AlecRabbit\Spinner\Core\Contracts\SpinnerSymbols;
use function AlecRabbit\typeOf;
use const AlecRabbit\ESC;

abstract class Spinner implements SpinnerInterface
{
    protected const ERASING_SHIFT = SettingsInterface::DEFAULT_ERASING_SHIFT;
    protected const INTERVAL = SettingsInterface::DEFAULT_INTERVAL;
    protected const SYMBOLS = SpinnerSymbols::DIAMOND;
    protected const STYLES = [];

    /** @var string */
    protected $messageStr;
    /** @var string */
    protected $percentStr = '';
    /** @var string */
    protected $percentPrefix;
    /** @var string */
    protected $moveBackSequenceStr;
    /** @var string */
    protected $inlinePaddingStr;
    /** @var string */
    protected $eraseBySpacesStr;
    /** @var Style */
    protected $style;
    /** @var float */
    protected $interval;
    /** @var int */
    protected $erasingShift;
    /** @var Circular */
    protected $symbols;

    /**
     * AbstractSpinner constructor.
     * @param mixed $settings
     * @param mixed $color
     */
    public function __construct($settings = null, $color = null)
    {
        $settings = $this->refineSettings($settings);
        $this->interval = $settings->getInterval();
        $this->erasingShift = $settings->getErasingShift();
        $this->inlinePaddingStr = $settings->getInlinePaddingStr();
        $this->messageStr = $this->getMessageStr($settings);
        $this->setFields();
        $this->symbols = new Circular($settings->getSymbols());
        try {
            $this->style = new Style($settings->getStyles(), $color);
        } catch (\Throwable $e) {
            throw new \InvalidArgumentException(
                '[' . static::class . '] ' . $e->getMessage(),
                (int)$e->getCode(),
                $e
            );
        }
    }

    /**
     * @param mixed $settings
     * @return SettingsInterface
     */
    protected function refineSettings($settings): SettingsInterface
    {
        $this->assertSettings($settings);
        if (\is_string($settings)) {
            return
                $this->defaultSettings()->setMessage($settings);
        }
        return
            $settings ?? $this->defaultSettings();
    }

    /**
     * @param mixed $settings
     */
    protected function assertSettings($settings): void
    {
        if (null !== $settings && !\is_string($settings) && !$settings instanceof SettingsInterface) {
            throw new \InvalidArgumentException(
                'Instance of SettingsInterface or string expected ' . typeOf($settings) . ' given.'
            );
        }
    }

    /**
     * @return SettingsInterface
     */
    protected function defaultSettings(): SettingsInterface
    {
        return
            (new Settings())
                ->setInterval(static::INTERVAL)
                ->setErasingShift(static::ERASING_SHIFT)
                ->setSymbols(static::SYMBOLS)
                ->setStyles(static::STYLES);
    }

    /**
     * @param SettingsInterface $settings
     * @return string
     */
    protected function getMessageStr(SettingsInterface $settings): string
    {
        return $settings->getPrefix() . ucfirst($settings->getMessage()) . $settings->getSuffix();
    }

    protected function setFields(): void
    {
        $this->percentPrefix = $this->getPrefix();
        $strLen =
            strlen($this->message()) + strlen($this->percent()) + strlen($this->inlinePaddingStr) + $this->erasingShift;
        $this->moveBackSequenceStr = ESC . "[{$strLen}D";
        $this->eraseBySpacesStr = str_repeat(SettingsInterface::ONE_SPACE_SYMBOL, $strLen);
    }

    /**
     * @return string
     */
    protected function getPrefix(): string
    {
        if (strpos($this->messageStr, SettingsInterface::DEFAULT_SUFFIX)) {
            return SettingsInterface::ONE_SPACE_SYMBOL;
        }
        return SettingsInterface::EMPTY;
    }

    /**
     * @return string
     */
    protected function message(): string
    {
        return $this->messageStr;
    }

    /**
     * @return string
     */
    protected function percent(): string
    {
        return $this->percentStr;
    }

    public function interval(): float
    {
        return $this->interval;
    }

    public function inline(bool $inline): SpinnerInterface
    {
        $this->inlinePaddingStr = $inline ? SettingsInterface::ONE_SPACE_SYMBOL : SettingsInterface::EMPTY;
        $this->setFields();
        return $this;
    }

    /** {@inheritDoc} */
    public function begin(?float $percent = null): string
    {
        return Cursor::hide() . $this->spin($percent);
    }

    /** {@inheritDoc} */
    public function spin(?float $percent = null): string
    {
        if (null !== $percent) {
            $this->updatePercent($percent);
        }
        return
            $this->inlinePaddingStr .
            $this->style->spinner((string)$this->symbols->value()) .
            $this->style->message(
                $this->message()
            ) .
            $this->style->percent(
                $this->percent()
            ) .
            $this->moveBackSequenceStr;
    }

    /**
     * @param float $percent
     */
    protected function updatePercent(float $percent): void
    {
        if (0 === (int)($percent * 1000) % 10) {
            $this->percentStr = Pretty::percent($percent, 0, $this->percentPrefix);
            $this->setFields();
        }
    }

    /** {@inheritDoc} */
    public function end(): string
    {
        return $this->erase() . Cursor::show();
    }

    /** {@inheritDoc} */
    public function erase(): string
    {
        return $this->eraseBySpacesStr . $this->moveBackSequenceStr;
    }
}
