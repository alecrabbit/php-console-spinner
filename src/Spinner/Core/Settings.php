<?php declare(strict_types=1);

namespace AlecRabbit\Spinner\Core;

use AlecRabbit\Spinner\Contracts\SettingsInterface;

class Settings implements SettingsInterface
{
    /** @var float */
    protected $interval;
    /** @var null|int */
    protected $erasingShift;
    /** @var null|string */
    protected $message;
    /** @var null|string */
    protected $prefix;
    /** @var null|string */
    protected $suffix;
    /** @var null|string */
    protected $paddingStr;

    /** @var null|array */
    protected $symbols;

    /** @var array */
    protected $styles;

    public function __construct()
    {
        $this->defaults();
    }

    public function defaults(): Settings
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
                ->setPaddingStr(null);
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
     * @return null|int
     */
    public function getErasingShift(): ?int
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
     * @param null|string $message
     * @return Settings
     */
    public function setMessage(?string $message): Settings
    {
        $this->message = $message ?? SettingsInterface::EMPTY;
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
    public function getPaddingStr(): string
    {
        return $this->paddingStr;
    }

    /**
     * @param null|string $paddingStr
     * @return Settings
     */
    public function setPaddingStr(?string $paddingStr): Settings
    {
        $this->paddingStr = $paddingStr ?? SettingsInterface::EMPTY;
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
        $this->styles = array_merge(static::DEFAULT_STYLES, $styles ?? []);
        return $this;
    }
}
