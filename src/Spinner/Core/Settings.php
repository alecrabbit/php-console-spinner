<?php declare(strict_types=1);

namespace AlecRabbit\Spinner\Core;

use AlecRabbit\Spinner\Core\Contracts\SettingsInterface;
use AlecRabbit\Spinner\Core\Contracts\StylesInterface;

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
        $this->initializeWithDefaults();
    }

    protected function initializeWithDefaults(): SettingsInterface
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

    /** {@inheritDoc} */
    public function getInterval(): float
    {
        return $this->interval;
    }

    /** {@inheritDoc} */
    public function setInterval(?float $interval): SettingsInterface
    {
        $this->interval = $interval ?? SettingsInterface::DEFAULT_INTERVAL;
        return $this;
    }

    /** {@inheritDoc} */
    public function getErasingShift(): int
    {
        return $this->erasingShift;
    }

    /** {@inheritDoc} */
    public function setErasingShift(?int $erasingShift): SettingsInterface
    {
        $this->erasingShift = $erasingShift ?? SettingsInterface::DEFAULT_ERASING_SHIFT;
        return $this;
    }

    /** {@inheritDoc} */
    public function getMessage(): string
    {
        return $this->message;
    }

    /** {@inheritDoc} */
    public function setMessage(?string $string): SettingsInterface
    {
        $this->message = $string ?? SettingsInterface::EMPTY;
        if (SettingsInterface::EMPTY === $this->message) {
            $this->setSuffix(SettingsInterface::EMPTY);
        } else {
            $this->setSuffix(SettingsInterface::DEFAULT_SUFFIX);
        }
        return $this;
    }

    /** {@inheritDoc} */
    public function getPrefix(): string
    {
        return $this->prefix;
    }

    /** {@inheritDoc} */
    public function setPrefix(?string $prefix): SettingsInterface
    {
        $this->prefix = $prefix ?? SettingsInterface::ONE_SPACE_SYMBOL;
        return $this;
    }

    /** {@inheritDoc} */
    public function getSuffix(): string
    {
        return $this->suffix;
    }

    /** {@inheritDoc} */
    public function setSuffix(?string $suffix): SettingsInterface
    {
        $this->suffix = $suffix ?? SettingsInterface::DEFAULT_SUFFIX;
        return $this;
    }

    /** {@inheritDoc} */
    public function getInlinePaddingStr(): string
    {
        return $this->inlinePaddingStr;
    }

    /** {@inheritDoc} */
    public function setInlinePaddingStr(?string $inlinePaddingStr): SettingsInterface
    {
        $this->inlinePaddingStr = $inlinePaddingStr ?? SettingsInterface::EMPTY;
        return $this;
    }

    /** {@inheritDoc} */
    public function getSymbols(): array
    {
        return $this->symbols;
    }

    /** {@inheritDoc} */
    public function setSymbols(?array $symbols): SettingsInterface
    {
        if (null !== $symbols && count($symbols) > SettingsInterface::MAX_SYMBOLS_COUNT) {
            throw new \InvalidArgumentException(
                sprintf('MAX_SYMBOLS_COUNT limit [%s] exceeded.', SettingsInterface::MAX_SYMBOLS_COUNT)
            );
        }
        $this->symbols = $symbols ?? static::DEFAULT_SYMBOLS;
        return $this;
    }

    /** {@inheritDoc} */
    public function getStyles(): array
    {
        return $this->styles;
    }

    /** {@inheritDoc} */
    public function setStyles(?array $styles): SettingsInterface
    {
        $this->styles = $this->mergeStyles(StylesInterface::DEFAULT_STYLES, $styles ?? []);
        return $this;
    }

    /**
     * @param array $defaultStyles
     * @param array $styles
     * @return array
     * todo move to another class?
     */
    protected function mergeStyles(array $defaultStyles, array $styles): array
    {
        foreach ($defaultStyles as $key => $defaults) {
            if (\array_key_exists($key, $styles)) {
                /** @noinspection SlowArrayOperationsInLoopInspection */
                $defaultStyles[$key] = array_merge($defaultStyles[$key], $styles[$key]);
            }
        }
        return $defaultStyles;
    }
}
