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
    protected $messagePrefix;
    /** @var string */
    protected $messageSuffix;
    /** @var string */
    protected $inlinePaddingStr;
    /** @var array */
    protected $frames;
    /** @var array */
    protected $styles;
    /** @var int */
    protected $messageErasingLen;
    /** @var string */
    protected $spacer;

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
                ->setMessageSuffix(null)
                ->setSpacer(null)
                ->setFrames(null)
                ->setStyles(null)
                ->setMessage(null)
                ->setMessagePrefix(null)
                ->setInterval(null)
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
//

    /** {@inheritDoc} */
    public function getErasingShift(): int
    {
        return $this->erasingShift;
    }

    /** {@inheritDoc} */
    public function getMessage(): string
    {
        return $this->message;
    }

    /** {@inheritDoc} */
    public function setMessage(?string $message, ?int $erasingLen = null): SettingsInterface
    {
        $this->message = $message ?? SettingsInterface::EMPTY;
        $this->messageErasingLen = $this->refineErasingLen($message, $erasingLen);
        if (SettingsInterface::EMPTY === $this->message) {
            $this->setMessageSuffix(SettingsInterface::EMPTY);
        } else {
            $this->setMessageSuffix(SettingsInterface::DEFAULT_SUFFIX);
        }
        return $this;
    }

    /**
     * @param null|string $string
     * @param null|int $erasingLen
     * @return int
     */
    protected function refineErasingLen(?string $string, ?int $erasingLen): int
    {
        if (null === $erasingLen) {
            return $this->computeErasingLen([$string]);
        }
        return $erasingLen;
    }

    /**
     * @param array $strings
     * @return int
     */
    protected function computeErasingLen(array $strings): int
    {
        if (empty($strings)) {
            return 0;
        }
        return $this->compErasingLen($strings);
    }

    private function compErasingLen(array $strings): int
    {
        // TODO check if all elements have the same erasingLen

        if (null === $symbol = $strings[0]) {
            return 0;
        }
        $mbSymbolLen = mb_strlen($symbol);
        $oneCharLen = strlen($symbol) / $mbSymbolLen;
        if (4 === $oneCharLen) {
            return 2 * $mbSymbolLen;
        }
        return 1 * $mbSymbolLen;
    }

    /** {@inheritDoc} */
    public function getMessagePrefix(): string
    {
        return $this->messagePrefix;
    }

    /** {@inheritDoc} */
    public function setMessagePrefix(?string $messagePrefix): SettingsInterface
    {
        $this->messagePrefix = $messagePrefix ?? SettingsInterface::ONE_SPACE_SYMBOL;
        return $this;
    }

    /** {@inheritDoc} */
    public function getMessageSuffix(): string
    {
        return $this->messageSuffix;
    }

    /** {@inheritDoc} */
    public function setMessageSuffix(?string $messageSuffix): SettingsInterface
    {
        $this->messageSuffix = $messageSuffix ?? SettingsInterface::DEFAULT_SUFFIX;
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
    public function getFrames(): array
    {
        return $this->frames;
    }

    /** {@inheritDoc} */
    public function setFrames(?array $symbols): SettingsInterface
    {
        if (null !== $symbols && count($symbols) > SettingsInterface::MAX_FRAMES_COUNT) {
            throw new \InvalidArgumentException(
                sprintf('MAX_SYMBOLS_COUNT limit [%s] exceeded.', SettingsInterface::MAX_FRAMES_COUNT)
            );
        }
        $this->frames = $symbols ?? static::DEFAULT_FRAMES;
        $this->erasingShift = $this->computeErasingLen($this->frames);
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

    public function merge(?SettingsInterface $settings): SettingsInterface
    {
        if ($settings instanceof SettingsInterface) {
            $this->interval = $settings->getInterval();
            $this->erasingShift = $settings->getErasingShift();
            $this->message = $settings->getMessage();
            $this->messagePrefix = $settings->getMessagePrefix();
            $this->messageSuffix = $settings->getMessageSuffix();
            $this->inlinePaddingStr = $settings->getInlinePaddingStr();
            $this->frames = $settings->getFrames();
            $this->styles = $settings->getStyles();
            $this->messageErasingLen = $settings->getMessageErasingLen();
            $this->spacer = $settings->getSpacer();
        }

        return $this;
    }

    /**
     * @return int
     */
    public function getMessageErasingLen(): int
    {
        return $this->messageErasingLen;
    }

    public function getSpacer(): string
    {
        return $this->spacer;
    }

    public function setSpacer(?string $spacer): SettingsInterface
    {
        $this->spacer = $spacer ?? SettingsInterface::EMPTY;
        return $this;
    }
}
