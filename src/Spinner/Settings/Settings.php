<?php declare(strict_types=1);

namespace AlecRabbit\Spinner\Settings;

use AlecRabbit\Spinner\Settings\Contracts\Defaults;
use AlecRabbit\Spinner\Settings\Contracts\S;
use AlecRabbit\Spinner\Settings\Contracts\SettingsInterface;

class Settings implements SettingsInterface
{
    /** @var Property[] */
    protected $properties;

    public function __construct()
    {
        $this->properties = $this->initialize();
    }

    /**
     * @return Property[]
     */
    private function initialize(): array
    {
        $properties = [];
        foreach (Defaults::DEFAULT_SETTINGS as $name => $value) {
            $properties[$name] = new Property($value);
        }
        return $properties;
    }

    /** {@inheritDoc} */
    public function getInterval(): float
    {
        return
            $this->properties[S::INTERVAL]->getValue();
    }

    /** {@inheritDoc} */
    public function setInterval(float $interval): self
    {
        $this->properties[S::INTERVAL]->setValue($interval);
        return $this;
    }

    /** {@inheritDoc} */
    public function getErasingShift(): int
    {
        return
            $this->properties[S::ERASING_SHIFT]->getValue();
    }

    /** {@inheritDoc} */
    public function getMessage(): string
    {
        return
            $this->properties[S::MESSAGE]->getValue();
    }

    /** {@inheritDoc} */
    public function setMessage(string $message, int $erasingLength = null): self
    {
        $this->properties[S::MESSAGE]->setValue($message);
        if (Defaults::EMPTY === $message) {
            $erasingLength = 0;
            $this->setMessageSuffix(Defaults::EMPTY);
        } else {
            $erasingLength = $this->refineErasingLen($message, $erasingLength);
            $this->setMessageSuffix(Defaults::DEFAULT_SUFFIX);
        }

        $this->properties[S::MESSAGE_ERASING_LENGTH]->setValue($erasingLength);
        return $this;
    }

    /**
     * @param string $string
     * @param null|int $erasingLen
     * @return int
     */
    protected function refineErasingLen(string $string, ?int $erasingLen): int
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
    public function setMessageSuffix(string $suffix): self
    {
        $this->properties[S::MESSAGE_SUFFIX]->setValue($suffix);
        return $this;
    }

    /** {@inheritDoc} */
    public function getMessagePrefix(): string
    {
        return
            $this->properties[S::MESSAGE_PREFIX]->getValue();
    }

    /** {@inheritDoc} */
    public function setMessagePrefix(string $prefix): self
    {
        $this->properties[S::MESSAGE_PREFIX]->setValue($prefix);
        return $this;
    }

    /** {@inheritDoc} */
    public function getMessageSuffix(): string
    {
        return
            $this->properties[S::MESSAGE_SUFFIX]->getValue();
    }

    /** {@inheritDoc} */
    public function getInlinePaddingStr(): string
    {
        return
            $this->properties[S::INLINE_PADDING_STR]->getValue();
    }

    /** {@inheritDoc} */
    public function setInlinePaddingStr(string $inlinePaddingStr): self
    {
        $this->properties[S::INLINE_PADDING_STR]->setValue($inlinePaddingStr);
        return $this;
    }

    /** {@inheritDoc} */
    public function getFrames(): array
    {
        return
            $this->properties[S::FRAMES]->getValue();
    }

    /** {@inheritDoc} */
    public function setFrames(array $frames): self
    {
        if (Defaults::MAX_FRAMES_COUNT < ($count = count($frames))) {
            throw new \InvalidArgumentException(
                sprintf('MAX_SYMBOLS_COUNT limit [%s] exceeded: [%s].', Defaults::MAX_FRAMES_COUNT, $count)
            );
        }
        $this->properties[S::FRAMES]->setValue($frames);
        $this->properties[S::ERASING_SHIFT]->setValue($this->computeErasingLen($frames));
        return $this;
    }

    /** {@inheritDoc} */
    public function getStyles(): array
    {
        return
            $this->properties[S::STYLES]->getValue();
    }

    /** {@inheritDoc} */
    public function setStyles(array $styles): self
    {
        $this->properties[S::STYLES]->setValue($styles);
        return $this;
    }

    /** {@inheritDoc} */
    public function getMessageErasingLen(): int
    {
        return
            $this->properties[S::MESSAGE_ERASING_LENGTH]->getValue();
    }

    /** {@inheritDoc} */
    public function getSpacer(): string
    {
        return
            $this->properties[S::SPACER]->getValue();
    }

    /** {@inheritDoc} */
    public function setSpacer(string $spacer): self
    {
        $this->properties[S::SPACER]->setValue($spacer);
        return $this;
    }

    /** {@inheritDoc} */
    public function merge(self $settings): self
    {
        foreach ($this->properties as $name => $value) {
            if ($settings->properties[$name]->isNotDefault()) {
                $this->properties[$name] = $settings->properties[$name];
            }
        }
        return $this;
    }
}
