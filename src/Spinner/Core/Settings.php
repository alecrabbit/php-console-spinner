<?php declare(strict_types=1);

namespace AlecRabbit\Spinner\Core;

use AlecRabbit\Spinner\Contracts\SettingsInterface;
use AlecRabbit\Spinner\Contracts\StylesInterface;

/**
 * Class Settings
 *
 * @psalm-suppress PropertyNotSetInConstructor
 */
class Settings implements SettingsInterface
{
    /** @var float */
    protected $interval;
    /** @var int */
    protected $erasingShift;
    /** @var string */
    protected $message;
    /** @var string */
    protected $prefix;
    /** @var string */
    protected $suffix;
    /** @var string */
    protected $inlinePaddingStr;
    /** @var array */
    protected $symbols;
    /** @var array */
    protected $styles;

    /**
     * Settings constructor.
     */
    public function __construct()
    {
        $this->defaults();
    }

    protected function defaults(): Settings
    {
        return
            $this
                ->setSuffix(null)
                ->setSymbols(null)
                ->setStyles(null)
                ->setMessage(null)
                ->setPrefix(null)
                ->setInterval(null)
                ->setErasingShift(null)
                ->setInlinePaddingStr(null);
    }

    /**
     * @return float
     */
    public function getInterval(): float
    {
        return $this->interval;
    }

    /**
     * @param null|float $interval
     * @return Settings
     */
    public function setInterval(?float $interval): Settings
    {
        $this->interval = $interval ?? SettingsInterface::DEFAULT_INTERVAL;
        return $this;
    }

    /**
     * @return int
     */
    public function getErasingShift(): int
    {
        return $this->erasingShift;
    }

    /**
     * @param null|int $erasingShift
     * @return Settings
     */
    public function setErasingShift(?int $erasingShift): Settings
    {
        $this->erasingShift = $erasingShift ?? SettingsInterface::DEFAULT_ERASING_SHIFT;
        return $this;
    }

    /**
     * @return string
     */
    public function getMessage(): string
    {
        return $this->message;
    }

    /**
     * @param null|string $string
     * @return Settings
     */
    public function setMessage(?string $string): Settings
    {
        $this->message = $string ?? SettingsInterface::EMPTY;
        if (SettingsInterface::EMPTY === $this->message) {
            $this->setSuffix(SettingsInterface::EMPTY);
        } else {
            $this->setSuffix(SettingsInterface::DEFAULT_SUFFIX);
        }
        return $this;
    }

    /**
     * @return string
     */
    public function getPrefix(): string
    {
        return $this->prefix;
    }

    /**
     * @param null|string $prefix
     * @return Settings
     */
    public function setPrefix(?string $prefix): Settings
    {
        $this->prefix = $prefix ?? SettingsInterface::ONE_SPACE_SYMBOL;
        return $this;
    }

    /**
     * @return string
     */
    public function getSuffix(): string
    {
        return $this->suffix;
    }

    /**
     * @param null|string $suffix
     * @return Settings
     */
    public function setSuffix(?string $suffix): Settings
    {
        $this->suffix = $suffix ?? SettingsInterface::DEFAULT_SUFFIX;
        return $this;
    }

    /**
     * @return string
     */
    public function getInlinePaddingStr(): string
    {
        return $this->inlinePaddingStr;
    }

    /**
     * @param null|string $inlinePaddingStr
     * @return Settings
     */
    public function setInlinePaddingStr(?string $inlinePaddingStr): Settings
    {
        $this->inlinePaddingStr = $inlinePaddingStr ?? SettingsInterface::EMPTY;
        return $this;
    }

    /**
     * @return array
     */
    public function getSymbols(): array
    {
        return $this->symbols;
    }

    /**
     * @param null|array $symbols
     * @return Settings
     */
    public function setSymbols(?array $symbols): Settings
    {
        $this->symbols = $symbols ?? static::DEFAULT_SYMBOLS;
        return $this;
    }

    /**
     * @return array
     */
    public function getStyles(): array
    {
        return $this->styles;
    }

    /**
     * @param null|array $styles
     * @return Settings
     */
    public function setStyles(?array $styles): Settings
    {
        $this->styles = $this->mergeStyles(StylesInterface::DEFAULT_STYLES, $styles ?? []);
        dump($styles);
//        dump($this->styles);
//        $this->styles = array_replace_recursive(static::NEW_DEFAULT_STYLES, $styles ?? []);
        return $this;
    }

    protected function mergeStyles(array $default_styles, array $styles): array
    {
        foreach ($default_styles as $key => $defaults) {
            if (\array_key_exists($key, $styles)) {
                /** @noinspection SlowArrayOperationsInLoopInspection */
                $default_styles[$key] = array_merge($default_styles[$key], $styles[$key]);
            }
        }
        return $default_styles;
    }
}
